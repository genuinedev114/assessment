<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlignSchemaWithAssessmentRequirements extends Migration
{
    public function up()
    {
        // This migration relies on DBAL-only column alterations; skip it for SQLite dev/test setups.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }

            if (Schema::hasColumn('brands', 'color') && !Schema::hasColumn('brands', 'primary_color')) {
                $table->renameColumn('color', 'primary_color');
            }

            if (!Schema::hasColumn('brands', 'logo_path')) {
                $table->string('logo_path')->nullable()->after('primary_color');
            }
        });

        DB::table('brands')->orderBy('id')->get()->each(function ($brand) {
            if (!$brand->slug) {
                DB::table('brands')->where('id', $brand->id)->update([
                    'slug' => \Illuminate\Support\Str::slug($brand->name . '-' . $brand->id),
                ]);
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('slug')->unique()->change();
        });

        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'number') && !Schema::hasColumn('stores', 'store_number')) {
                $table->renameColumn('number', 'store_number');
            }

            if (Schema::hasColumn('stores', 'address') && !Schema::hasColumn('stores', 'address_line_1')) {
                $table->renameColumn('address', 'address_line_1');
            }

            if (Schema::hasColumn('stores', 'zip_code') && !Schema::hasColumn('stores', 'postal_code')) {
                $table->renameColumn('zip_code', 'postal_code');
            }
        });

        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'address_line_2')) {
                $table->string('address_line_2')->nullable()->after('address_line_1');
            }

            if (!Schema::hasColumn('stores', 'country')) {
                $table->string('country')->default('US')->after('postal_code');
            }
        });

        DB::statement("UPDATE stores SET country = 'US' WHERE country IS NULL OR country = ''");

        if (Schema::hasTable('journals') && !Schema::hasTable('store_journals')) {
            Schema::rename('journals', 'store_journals');
        }

        Schema::table('store_journals', function (Blueprint $table) {
            if (Schema::hasColumn('store_journals', 'date') && !Schema::hasColumn('store_journals', 'business_date')) {
                $table->renameColumn('date', 'business_date');
            }
        });

        Schema::table('store_journals', function (Blueprint $table) {
            $table->decimal('revenue', 12, 2)->change();
            $table->decimal('food_cost', 12, 2)->change();
            $table->decimal('labor_cost', 12, 2)->change();
            $table->decimal('profit', 12, 2)->change();

            $table->index(['store_id', 'business_date'], 'store_journals_store_id_business_date_idx');
            $table->unique(['store_id', 'business_date'], 'store_journals_store_id_business_date_unique');
        });

        if (Schema::hasTable('store_user') && !Schema::hasTable('owner_store_assignments')) {
            Schema::rename('store_user', 'owner_store_assignments');
        }

        Schema::table('owner_store_assignments', function (Blueprint $table) {
            $table->unique(['user_id', 'store_id'], 'owner_store_assignments_user_store_unique');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->unique(['brand_id', 'store_number'], 'stores_brand_store_number_unique');
        });

        Schema::create('export_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['queued', 'processing', 'completed', 'failed'])->default('queued');
            $table->string('file_path')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('export_requests');

        if (Schema::hasTable('owner_store_assignments') && !Schema::hasTable('store_user')) {
            Schema::rename('owner_store_assignments', 'store_user');
        }

        if (Schema::hasTable('store_journals') && !Schema::hasTable('journals')) {
            Schema::rename('store_journals', 'journals');
        }
    }
}

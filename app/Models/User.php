<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_brand_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function brands()
    {
        return $this->hasManyThrough(
            Brand::class,
            Store::class,
            'id',
            'id',
            'id',
            'brand_id'
        )->distinct();
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_user')->withTimestamps();
    }

    public function currentBrand()
    {
        return $this->belongsTo(Brand::class, 'current_brand_id');
    }

  
    public function currentBrandStores()
    {
        if (!$this->current_brand_id) {
            return collect([]);
        }
        return $this->stores()->where('brand_id', $this->current_brand_id);
    }
}

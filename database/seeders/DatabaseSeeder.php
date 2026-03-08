<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Journal;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create test user
        $user = User::create([
            'name' => 'Test Owner',
            'email' => 'owner@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create brands with specific colors
        $brands = [
            ['name' => 'Taco Bell', 'color' => '#702082'],
            ['name' => 'KFC', 'color' => '#E4002B'],
            ['name' => 'Pizza Hut', 'color' => '#00953B'],
            ['name' => 'Popeyes', 'color' => '#E1251B'],
        ];

        foreach ($brands as $brandData) {
            $brand = Brand::create($brandData);

            // Create 2-4 stores per brand
            $storeCount = rand(2, 4);
            for ($i = 0; $i < $storeCount; $i++) {
                $store = Store::create([
                    'brand_id' => $brand->id,
                    'number' => $brand->id . '00' . ($i + 1),
                    'address' => $this->faker()->streetAddress(),
                    'city' => $this->faker()->city(),
                    'state' => $this->faker()->stateAbbr(),
                    'zip_code' => $this->faker()->postcode(),
                ]);

                // Attach stores to user
                $user->stores()->attach($store->id);

                // Create a year's worth of journal entries
                $startDate = now()->subYear();
                for ($day = 0; $day < 365; $day++) {
                    $date = $startDate->copy()->addDays($day);
                    $revenue = rand(5000, 15000);
                    $foodCost = rand((int)($revenue * 0.25), (int)($revenue * 0.35));
                    $laborCost = rand((int)($revenue * 0.20), (int)($revenue * 0.30));
                    $profit = $revenue - $foodCost - $laborCost;

                    Journal::create([
                        'store_id' => $store->id,
                        'date' => $date,
                        'revenue' => $revenue,
                        'food_cost' => $foodCost,
                        'labor_cost' => $laborCost,
                        'profit' => $profit,
                    ]);
                }
            }
        }

        // Set first brand as current for user
        $user->update(['current_brand_id' => Brand::first()->id]);
    }

    private function faker()
    {
        return \Faker\Factory::create();
    }
}

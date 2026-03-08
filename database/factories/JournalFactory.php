<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $revenue = $this->faker->numberBetween(5000, 15000);
        $foodCost = $this->faker->numberBetween(int($revenue * 0.25), int($revenue * 0.35));
        $laborCost = $this->faker->numberBetween(int($revenue * 0.20), int($revenue * 0.30));
        $profit = $revenue - $foodCost - $laborCost;

        return [
            'store_id' => Store::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'revenue' => $revenue,
            'food_cost' => $foodCost,
            'labor_cost' => $laborCost,
            'profit' => $profit,
        ];
    }
}

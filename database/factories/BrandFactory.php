<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $brands = [
            ['name' => 'Taco Bell', 'color' => '#702082'],
            ['name' => 'KFC', 'color' => '#E4002B'],
            ['name' => 'Pizza Hut', 'color' => '#00953B'],
            ['name' => 'Popeyes', 'color' => '#E1251B'],
            ['name' => 'The Habit', 'color' => '#000000'],
        ];

        $brand = $this->faker->randomElement($brands);

        return [
            'name' => $brand['name'],
            'color' => $brand['color'],
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(rand(2, 3), true),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 499),
            'top' => $this->faker->boolean(13),
        ];
    }
}

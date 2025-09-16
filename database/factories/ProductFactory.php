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
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(100),
            'price' => $this->faker->numberBetween(10000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'is_favorite' => $this->faker->boolean,
            'status' => $this->faker->boolean,
            'category_id' => $this->faker->numberBetween(1, 2),
            'sub_category_id' => $this->faker->numberBetween(1, 5),
            'image' => $this->faker->imageUrl(640, 480),
        ];
    }
}

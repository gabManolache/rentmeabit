<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'rents' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_by' => null,
            'created_at' => now(),
            'updated_by' => null,
            'updated_at' => now(),
            'deleted_at' => null,
            'deleted' => 'no',
        ];
    }
}
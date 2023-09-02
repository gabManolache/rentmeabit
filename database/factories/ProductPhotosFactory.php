<?php

namespace Database\Factories;

use App\Models\ProductPhotos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPhotos>
 */
class ProductPhotosFactory extends Factory
{

    protected $model = ProductPhotos::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        'id_product' => function () {
            return \App\Models\Product::factory()->create()->id;
        },
        'url' => $this->faker->imageUrl(),
        'description' => $this->faker->sentence,
        'width' => $this->faker->numberBetween(100, 1000),
        'height' => $this->faker->numberBetween(100, 1000),
    ];
    }
}
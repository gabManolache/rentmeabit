<?php

namespace Database\Factories;

use App\Models\ProductPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPhoto>
 */
class ProductPhotoFactory extends Factory
{

    protected $model = ProductPhoto::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        'product_id' => function () {
            return \App\Models\Product::factory()->create()->id;
        },
        'url' => $this->faker->imageUrl(),
        'description' => $this->faker->sentence,
        'width' => $this->faker->numberBetween(100, 1000),
        'height' => $this->faker->numberBetween(100, 1000),
        'main' => $this->faker->boolean,  // Aggiunto il nuovo campo 'main'

    ];
    }
}

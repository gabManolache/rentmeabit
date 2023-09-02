<?php

namespace Database\Factories;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductFeedback>
 */
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductFeedback;

class ProductFeedbackFactory extends Factory
{
    protected $model = ProductFeedback::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'user_id' => \App\Models\User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
        ];
    }
}

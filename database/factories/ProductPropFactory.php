<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductProp>
 */
class ProductPropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('Code_??##'), // Genera un codice univoco
            'label' => $this->faker->word,
            'product_id' => \App\Models\Product::factory(), // Assicurati che questo sia il namespace corretto del tuo modello Product
            'value' => $this->faker->word,
        ];
    }
}

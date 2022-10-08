<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => product::all()->random()->id,
            'count' => $this->faker->randomNumber(2),
            'size' => $this->faker->numberBetween(21,44),
            'price' => $this->faker->numberBetween(100000,5000000),
        ];
    }
}

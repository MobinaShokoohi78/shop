<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\product;
use App\Models\Size;
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
            'size_id' => Size::all()->random()->id,
            'color_id' => Color::all()->random()->id,
            'price' => $this->faker->numberBetween(100000,5000000),
        ];
    }
}

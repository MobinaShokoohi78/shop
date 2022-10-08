<?php

namespace Database\Factories;

use App\Models\product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->word(),
            'parent' => 0,
            'user_id' => User::all()->random()->id,
            'product_id' => product::all()->random()->id,
        ];
    }
}

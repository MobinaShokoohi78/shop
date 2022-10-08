<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word(),
            'url'=>$this->faker->url(),
            'small_name'=>$this->faker->word().'_small',
            'medium_name'=>$this->faker->word().'_mediuem',
            'large_name'=>$this->faker->word().'_large',
            'original_name'=>$this->faker->word().'_orginal',
            'alt'=>$this->faker->word(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewbornFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image_id' => null,
            'owner_id' => \App\Models\User::all()->random()->id,
        ];
    }
}

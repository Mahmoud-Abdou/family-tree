<?php

namespace Database\Factories;

use App\Models\Death;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeathFactory extends Factory
{
    protected $model = Death::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'image_id' => null,
            'owner_id' => \App\Models\User::all()->unique()->random()->id,
        ];
    }
}

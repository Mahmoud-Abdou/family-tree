<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_id' => function() {
             return \App\Models\User::all()->random()->id;
            },
            'city_id' => function() {
                return \App\Models\City::all()->random()->id;
            },
            'title' => $this->faker->realText(20),
            'body' => $this->faker->realText(300),
            'image_id' => $this->faker->numberBetween(1, 50),
            'category_id' => function() {
                return \App\Models\Category::all()->random()->id;
            },
            'event_date' => $this->faker->dateTime,
            'approved' => $this->faker->boolean(75),
            'approved_by' => function() {
                return \App\Models\User::all()->random()->id;
            },
        ];
    }
}

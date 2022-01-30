<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = \App\Models\City::all();
        $cities = $city->map(function ($item) {
            return $item['id'];
        });
        $citiesIdes = $cities->all();

        return [
            'name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->phoneNumber(),
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
            'role_id' => 3,
            'city_id' => $this->faker->randomElement($citiesIdes),
//            'city_id' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['registered', 'active']),
            'accept_terms' => true,
        ];


    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

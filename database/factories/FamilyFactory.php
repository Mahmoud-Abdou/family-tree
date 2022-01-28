<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => function() {
             return  'عائلة ' . \App\Models\User::all()->unique()->random()->name;
            },
            'father_id' => function() {
            return \App\Models\Person::all()->unique()->random()->id;
            },
            'mother_id' => function() {
                return \App\Models\Person::all()->unique()->random()->id;
            },
            'children_count' => $this->faker->numberBetween(0, 8),
            'gf_family_id' => $this->faker->numberBetween(1, 30),
            'status' => $this->faker->numberBetween(1, 5),
//            'family_tree' => null
        ];
    }

}

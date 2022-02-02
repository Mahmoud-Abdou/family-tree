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
        $father = \App\Models\Person::where('gender', 'male')->where('has_family', true)->get()->random();
        $mothersAll = \App\Models\Person::where('gender', '=', 'female')->get();
        $mothers = $mothersAll->map(function ($item) {
            return $item['id'];
        });
        $mothersIdes = $mothers->all();

        return [
            'name' => 'عائلة ' . $father->first_name,
            'father_id' => $father->id,
            'mother_id' => $this->faker->unique()->randomElement($mothersIdes),
//            'children_count' => $this->faker->numberBetween(0, 8),
            'gf_family_id' => $this->faker->numberBetween(1, 40) || null,
            'status' => $this->faker->numberBetween(1, 5),
//            'family_tree' => null
        ];
    }

}

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
        $fatherAll = \App\Models\Person::where('gender', '=', 'male')->where('has_family', true)->get();
        $fathers = $fatherAll->map(function ($item) {
            return $item['id'];
        });
        $fatherIdes = $fathers->all();
        $father = \App\Models\Person::find($this->faker->randomElement($fatherIdes));
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
            'gf_family_id' => $this->faker->numberBetween(10, 70),
            'status' => $this->faker->numberBetween(1, 5),
//            'family_tree' => null
        ];
    }

}

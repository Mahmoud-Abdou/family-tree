<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = \App\Models\User::all()->unique()->random();
        $gender = $this->faker->randomElement(['male', 'female']);
        $isLive = $this->faker->boolean(75);

        $user->name = $this->faker->firstName($gender);
        $user->save();

        return [
//            'user_id' => factory(\App\Models\User::class)->create()->id,
            'user_id' => $user->id,
            'first_name' => $user->name,
            'father_name' => $this->faker->firstNameMale(),
            'grand_father_name' => $this->faker->firstNameMale(),
//            'surname' => null,
            'prefix' => $this->faker->title($gender),
            'job' => $this->faker->jobTitle(),
            'bio' => $this->faker->realText(300),
            'gender' => $gender,
//            'photo' => $this->faker->randomElement(['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png', '8.png', '9.png', '10.png']),
            'has_family' => $this->faker->boolean(40),
            'family_id' => $this->faker->numberBetween(1, 50),
            'relation' => $this->faker->randomElement(config('custom.relations-types')),
            'address' => $this->faker->address(),
            'is_live' => $isLive,
            'birth_date' => $this->faker->date('Y-m-d', 'now'),
            'birth_place' => $this->faker->city(),
            'death_date' => $isLive ? null : $this->faker->date('Y-m-d', 'now'),
            'death_place' => $isLive ? null : $this->faker->city(),
            'verified' => $this->faker->boolean(90),
//            'symbol' => null,
            'color' => $this->faker->hexColor,
        ];
    }

}

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
        $user_id = \App\Models\User::all()->random()->id;
        $category_id = \App\Models\Category::all()->random()->id;
        $approvedRound = $this->faker->boolean(75);

        $media = \App\Models\Media::create([
            'owner_id' => $user_id,
            'file' => $this->faker->image('public/uploads/media',600,400, 'nature', false),
            'category_id' => $category_id
        ]);

        return [
            'owner_id' => $user_id,
            'city_id' => function() {
                return \App\Models\City::all()->random()->id;
            },
            'title' => $this->faker->realText(20),
            'body' => $this->faker->realText(300),
            'image_id' => $media->id,
            'category_id' => $category_id,
            'event_date' => $this->faker->dateTime,
            'approved' => $approvedRound,
            'approved_by' => $approvedRound ? 1 : null,
        ];
    }
}

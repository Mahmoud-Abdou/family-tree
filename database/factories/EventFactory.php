<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = \App\Models\User::all()->random()->id;
        $category_id = \App\Models\Category::where('type', 'event')->get()->random()->id;
        $approvedRound = $this->faker->boolean(75);

        $media = \App\Models\Media::create([
            'owner_id' => $user_id,
            'title' => $this->faker->realText(20),
//            'file' => $this->faker->image('public/uploads/media',600,300, '600x300', false),
            'file' => $this->faker->image('public/uploads/media',384,250, 2, false),
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
//            'event_date' => $this->faker->dateTime(),
            'event_date' => $this->faker->dateTimeBetween('now', '+120 days'),
            'approved' => $approvedRound,
            'approved_by' => $approvedRound ? 1 : null,
        ];
    }
}

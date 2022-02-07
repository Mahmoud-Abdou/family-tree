<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonsSeeder extends Seeder
{
    protected $model = Person::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Person::factory(301)->create()->each(function($person) {
            if (!$person->is_live) {
                \App\Models\Death::factory()->create([
                    'person_id' => $person->id,
                    'family_id' => $person->family_id,
                    'title' => 'وفاة '. $person->first_name,
                    'body' => 'انتقل الى رحمة الله '. $person->first_name . $person->gender == 'male' ? ' ابن ' : ' ابنة ' . $person->father_name ,
                ]);
            }
            else {
                \App\Models\Newborn::factory()->create([
                    'person_id' => $person->id,
                    'date' => $person->birth_date,
                    'family_id' => $person->family_id,
                    'title' => 'ولادة '. $person->first_name,
                    'body' => 'بفضل من الله رزقنا بمولودنا '. $person->first_name . $person->gender == 'male' ? ' ابن ' : ' ابنة ' . $person->father_name,
                ]);
            }
        });
    }
}

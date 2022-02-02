<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FamiliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Family::factory(120)->create();

        $families = \App\Models\Family::all();
        foreach ($families as $family) {
            $family->children_count = \App\Models\Person::where('family_id', $family->id)->count();
            $family->save();
        }
    }
}

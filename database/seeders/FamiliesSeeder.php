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

            foreach ($family->members as $member) {
                if ($member->id != $family->mother->id && $member->id != $family->father->id) {
                    $member->father_name = $family->father->first_name;
                    $member->grand_father_name = $family->parentFamily->father->first_name;
                }
                $member->save();
            }
        }
    }
}

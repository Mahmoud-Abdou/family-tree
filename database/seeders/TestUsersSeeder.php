<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'وليد',
            'email' => 'waleed@alflk.sa',
            'mobile' => '123456789',
            'role_id' => 1,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user->id,
            'first_name' => $user->name,
            'father_name' => 'علي',
            'grand_father_name' => 'عبدالله',
            'surname' => 'ابو سلطان',
            'gender' => 'male',
            'prefix' => '',
            'job' => 'مدير عام',
            'bio' => '',
            'address' => '',
            'has_family' => true,
            'is_live' => true,
            'birth_place' => 'الرياض',
            'birth_date' => '1970-01-01',
        ]);

        $user->assignRole('Super Admin');

        $user2 = User::create([
            'name' => 'وفاء',
            'email' => 'wafa@alflk.sa',
            'mobile' => '987654321',
            'role_id' => 1,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user2->id,
            'first_name' => $user2->name,
            'father_name' => 'محمد',
            'grand_father_name' => 'سليمان الطجل',
            'surname' => 'أم سلطان',
            'gender' => 'female',
            'prefix' => 'الدكتورة',
            'job' => '',
            'bio' => '',
            'address' => '',
            'has_family' => true,
            'is_live' => true,
        ]);

        $user2->assignRole('Super Admin');

        $family = Family::create([
            'name' => 'عائلة '.$user->name,
            'father_id' => $user->id,
            'mother_id' => $user2->id,
            'children_count' => 4,
            'gf_family_id'=> null,
            'status' => 1,
        ]);

        $user3 = User::create([
            'name' => 'سلطان',
            'email' => 'sultan@alflk.sa',
            'mobile' => '1111111111',
            'role_id' => 2,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user3->id,
            'first_name' => $user3->name,
            'father_name' => 'وليد',
            'grand_father_name' => 'علي',
            'surname' => '',
            'gender' => 'male',
            'prefix' => '',
            'job' => '',
            'bio' => '',
            'address' => '',
            'family_id' => $family->id,
            'has_family' => false,
            'is_live' => true,
        ]);

        $user3->assignRole('Moderator');

        $user4 = User::create([
            'name' => 'حياة',
            'email' => 'hayat@alflk.sa',
            'mobile' => '2222222222',
            'role_id' => 3,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user4->id,
            'first_name' => $user4->name,
            'father_name' => 'وليد',
            'grand_father_name' => 'علي',
            'surname' => '',
            'gender' => 'female',
            'prefix' => '',
            'job' => '',
            'bio' => '',
            'address' => '',
            'family_id' => $family->id,
            'has_family' => false,
            'is_live' => true,
        ]);

        $user4->assignRole('Viewer');

        $user5 = User::create([
            'name' => 'هند',
            'email' => 'hend@alflk.sa',
            'mobile' => '333333333',
            'role_id' => 3,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user5->id,
            'first_name' => $user5->name,
            'father_name' => 'وليد',
            'grand_father_name' => 'علي',
            'surname' => '',
            'gender' => 'female',
            'prefix' => '',
            'job' => '',
            'bio' => '',
            'address' => '',
            'family_id' => $family->id,
            'has_family' => false,
            'is_live' => true,
        ]);

        $user5->assignRole('Viewer');

        $user6 = User::create([
            'name' => 'فيصل',
            'email' => 'fisal@alflk.sa',
            'mobile' => '444444444',
            'role_id' => 3,
            'city_id' => 1,
            'password' => '123456789',
            'status' => 'active',
            'accept_terms' => true
        ]);

        Person::create([
            'user_id' => $user6->id,
            'first_name' => $user6->name,
            'father_name' => 'وليد',
            'grand_father_name' => 'علي',
            'surname' => '',
            'gender' => 'male',
            'prefix' => '',
            'job' => '',
            'bio' => '',
            'address' => '',
            'family_id' => $family->id,
            'has_family' => false,
            'is_live' => true,
        ]);

        $user6->assignRole('Viewer');
    }
}

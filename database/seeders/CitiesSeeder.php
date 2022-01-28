<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['slug' => '', 'name_ar' => 'الرياض', 'name_en' => 'Riyadh', 'country_ar' => 'المملكة العربية السعودية', 'country_en' => 'Saudi Arabia'],
            ['slug' => '', 'name_ar' => 'جدة', 'name_en' => 'Jeddah', 'country_ar' => 'المملكة العربية السعودية', 'country_en' => 'Saudi Arabia'],
            ['slug' => '', 'name_ar' => 'حائل', 'name_en' => 'Haiel', 'country_ar' => 'المملكة العربية السعودية', 'country_en' => 'Saudi Arabia'],
            ['slug' => '', 'name_ar' => 'القصيم', 'name_en' => 'Qaseem', 'country_ar' => 'المملكة العربية السعودية', 'country_en' => 'Saudi Arabia'],
            ['slug' => '', 'name_ar' => 'الدمام', 'name_en' => 'Dammam', 'country_ar' => 'المملكة العربية السعودية', 'country_en' => 'Saudi Arabia'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

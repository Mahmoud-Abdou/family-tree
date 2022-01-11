<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'app_title_ar' => 'عائلة الصهيل',
            'app_title_en' => 'Al Saheel Family',
            'app_description_ar' => 'عائلة الصهيل',
            'app_description_en' => 'Al Saheel Family',
            'app_about_ar' => 'عائلة الصهيل',
            'app_about_en' => 'Al Saheel Family',
            'app_contact_ar' => '----',
            'app_contact_en' => '----',
            'app_terms_ar' => 'الشروط',
            'app_terms_en' => 'Terms',
            'app_logo' => 'logo.png',
            'app_icon' => 'icon.png',
            'family_tree_image' => 'family.png',
            'family_name_ar' => 'عائلة الصهيل',
            'family_name_en' => 'Al Saheel Family',
            'app_registration' => true,
        ]);
    }
}

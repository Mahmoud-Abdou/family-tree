<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['slug' => 'general', 'name_ar' => 'عام', 'name_en' => 'General', 'type' => 'general'],
            ['slug' => 'newborn', 'name_ar' => 'المواليد', 'name_en' => 'Newborn', 'type' => 'newborn'],
            ['slug' => 'death', 'name_ar' => 'الوفيات', 'name_en' => 'Deaths', 'type' => 'deaths'],
            ['slug' => 'marriages', 'name_ar' => 'الزواجات', 'name_en' => 'Marriages', 'type' => 'marriages'],
            ['slug' => 'event', 'name_ar' => 'المناسبات', 'name_en' => 'Event', 'type' => 'event'],
            ['slug' => 'meetings', 'name_ar' => 'الاجتماعات', 'name_en' => 'Meetings', 'type' => 'event'],
            ['slug' => 'celebrations', 'name_ar' => 'احتفالات', 'name_en' => 'Celebrations', 'type' => 'news'],
            ['slug' => 'marriages', 'name_ar' => 'الزواجات', 'name_en' => 'Marriages', 'type' => 'news'],
            ['slug' => 'newborn', 'name_ar' => 'المواليد', 'name_en' => 'Newborn', 'type' => 'news'],
            ['slug' => 'graduate', 'name_ar' => 'تخرج', 'name_en' => 'Graduate', 'type' => 'news'],
            ['slug' => 'urgent', 'name_ar' => 'عاجل', 'name_en' => 'Urgent', 'type' => 'news'],
            ['slug' => 'images', 'name_ar' => 'صور', 'name_en' => 'Images', 'type' => 'media'],
            ['slug' => 'video', 'name_ar' => 'فيديو', 'name_en' => 'Video', 'type' => 'media'],
        ];
        // types = ['general', 'media', 'video', 'event', 'news', 'newborn', 'marriages'];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

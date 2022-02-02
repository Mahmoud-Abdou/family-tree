<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            SettingsSeeder::class,
            RolesAndPermissionsSeeder::class,
            CategoriesSeeder::class,
            CitiesSeeder::class,
            UsersSeeder::class,
            PersonsSeeder::class,
            FamiliesSeeder::class,
            EventsSeeder::class
        ]);

    }
}

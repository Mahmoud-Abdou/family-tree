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
        ]);

        echo "Seeding: users ...... Start  \r\n";
        \App\Models\User::factory(300)->create()->each(function($u) {
            $u->assignRole('Viewer');;
        });
        echo "Seeded: users ...... (done) \r\n";
        echo "Seeding: persons ...... Start  \r\n";
        \App\Models\Person::factory(300)->create();
        echo "Seeded: persons ...... done  \r\n";
        echo "Seeding: families ...... Start  \r\n";
        \App\Models\Family::factory(100)->create();
        echo "Seeded: families ...... done  \r\n";
        echo "Seeding: events ...... Start  \r\n";
        \App\Models\Event::factory(50)->create();
        echo "Seeded: events ...... done  \r\n";

    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
//use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = config('custom.permissions');
        foreach ($permissions as $key =>  $per) {
            echo "Role: " . $key . " ......done  \r\n";
            foreach ($per as $p) {
                Permission::create($p);
            }
        }

        // create roles and assign created permissions
        $roleAdmin = Role::create(['name' => 'Super Admin', 'name_ar' => 'مدير التطبيق', 'description' => 'المدير الأساسي لكافة العمليات']);
        $roleAdmin->givePermissionTo(Permission::all());

        // or may be done by chaining
        Role::create(['name' => 'Moderator', 'name_ar' => 'مسؤول', 'description' => 'مسؤول عن بعض العمليات'])
            ->givePermissionTo(['users.read', 'users.update', 'users.activate', 'cities.read', 'cities.create', 'cities.update', 'cities.delete']);

        // this can be done as separate statements
        Role::create(['name' => 'Viewer', 'name_ar' => 'مستخدم', 'description' => 'مستخدم بصلاحيات شخصية']);

        // create super admin user
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'loai@alflk.sa',
            'mobile' => '0501673338',
            'role_id' => $roleAdmin->id,
            'city_id' => null,
            'password' => 'Pass@1234',
            'status' => 'active',
            'accept_terms' => true
        ]);

        $user->assignRole('Super Admin');

    }
}

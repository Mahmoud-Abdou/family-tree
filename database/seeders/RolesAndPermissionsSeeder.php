<?php

namespace Database\Seeders;

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
        Permission::create(['name' => 'users.read', 'name_ar' => 'مشاهدة المستخدمين', 'description' => 'مشاهدة المستخدمين']);
        Permission::create(['name' => 'users.create', 'name_ar' => 'اضافة المستخدمين', 'description' => 'اضافة المستخدمين']);
        Permission::create(['name' => 'users.update', 'name_ar' => 'تعديل المستخدمين', 'description' => 'تعديل المستخدمين']);
        Permission::create(['name' => 'users.delete', 'name_ar' => 'حذف المستخدمين', 'description' => 'حذف المستخدمين']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin', 'name_ar' => 'مدير التطبيق', 'description' => 'المدير الأساسي لكافة العمليات']);
        $role->givePermissionTo(Permission::all());

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator', 'name_ar' => 'مسؤول', 'description' => 'مسؤول عن بعض العمليات'])
            ->givePermissionTo(['users.read', 'users.update']);

        // this can be done as separate statements
        $role = Role::create(['name' => 'viewer', 'name_ar' => 'مستخدم', 'description' => 'مستخدم بصلاحيات شخصية']);
        $role->givePermissionTo('users.read');
    }
}

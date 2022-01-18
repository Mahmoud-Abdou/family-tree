<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles.read')->only(['index', 'show']);
        $this->middleware('permission:roles.create')->only(['create', 'store']);
        $this->middleware('permission:roles.update')->only(['edit', 'update']);
        $this->middleware('permission:roles.delete')->only('destroy');
    }

    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الصلاحيات';
        $pageTitle = 'لوحة التحكم';

        $rolesData = Role::where('name', '!=', 'Super Admin')->get();
        $permissions = Permission::all();
        $cities = \App\Models\City::all();

        foreach ($rolesData as $role) {
            $role->usersCount = \App\Models\User::role($role->name)->count();
        }

        return view('dashboard.roles.index', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'permissions', 'rolesData', 'cities'
        ));
    }

    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'اضافة الصلاحيات';
        $pageTitle = 'لوحة التحكم';

        $roles = config('custom.roles');
        $permissions = config('custom.permissions');
        $cities = \App\Models\City::all();

        return view('dashboard.roles.create', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'permissions', 'roles', 'cities'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:roles'],
            'name_ar' => ['required'],
            'description' => ['nullable'],
            'cities' => ['nullable'],
        ]);

        $request['guard_name'] = 'web';

//        $role = Role::create($request->all());
        $role = new Role();
        $role->name = $request->name;
        $role->name_ar = $request->name_ar;
        $role->description = $request->description;
        $role->cities = $request->cities;
        $role->guard_name = $request->guard_name;
        $role->save();

        $role->syncPermissions($request->permissions);

        if(!$role){
            return back('roles.index')->with('error', 'حصل خطأ في البيانات.');
        }

        \App\Helpers\AppHelper::AddLog('ٍRole Create', class_basename($role), $role->id);

        return redirect()->route('roles.index')->with('success', 'تم انشاء صلاحية جديدة و يمكنك استخدامها.');
    }

    public function show($id)
    {
        return redirect()->route('roles.edit', $id);
    }

    public function edit($id)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل الصلاحيات';
        $pageTitle = 'لوحة التحكم';

        $role = Role::findById($id);
        $roles = config('custom.roles');
        $permissions = config('custom.permissions');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $cities = \App\Models\City::all();

        return view('dashboard.roles.update', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'permissions', 'roles', 'role', 'rolePermissions', 'cities'
        ));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name,'.$id],
            'name_ar' => ['required'],
            'description' => ['nullable'],
            'cities' => ['nullable'],
        ]);

        $role = Role::findById($id);
        $role->update($request->all());

        $role->syncPermissions($request->permissions);

        \App\Helpers\AppHelper::AddLog('ٍRole Updateْ', class_basename($role), $role->id);

        return redirect()->route('roles.index')->with('success', 'تم تعديل الصلاحية المحددة بنجاح.');
    }

    public function destroy($id)
    {
        $role = Role::findById($id);
//        $role->syncPermissions([]);
        $role->revokePermissionTo($role->permissions);
        $role->delete();

        \App\Helpers\AppHelper::AddLog('ٍRole Delete', class_basename($role), $role->id);

        return redirect()->route('roles.index')->with('success', 'تم حذف الصلاحية المحددة بنجاح.');

    }
}

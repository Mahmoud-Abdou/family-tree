<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\FosterBrother;
use App\Models\Person;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.read')->only(['index', 'show']);
        $this->middleware('permission:users.create')->only(['create', 'store']);
        $this->middleware('permission:users.update')->only(['edit', 'update', 'roleAssign']);
        $this->middleware('permission:users.delete')->only('destroy');
        $this->middleware('permission:users.activate')->only('activate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'المستخدمين';
        $pageTitle = 'لوحة التحكم';

        $perPage = isset($_GET['per-page']) ? $_GET['per-page'] : 10;
        $perCity = isset($_GET['city']) && $_GET['city'] != 'all' ? $_GET['city'] : null;
        $perRole = isset($_GET['role']) && $_GET['role'] != 'all' ? $_GET['role'] : null;
        $perStatus = isset($_GET['status']) && $_GET['status'] != 'all' ? $_GET['status'] : null;
        $perMobile = isset($_GET['mobile']) ? $_GET['mobile'] : null;
        $perEmail = isset($_GET['email']) ? $_GET['email'] : null;

//        $usersData = User::simplePaginate($perPage);
        $usersData = User::where([
            ['city_id', $perCity ? '=' : '<>', $perCity],
            ['role_id', $perRole ? '=' : '<>', $perRole],
            ['status', $perStatus ? '=' : '<>', $perStatus],
            ['mobile', $perMobile ? '=' : '<>', $perMobile],
            ['email', $perEmail ? '=' : '<>', $perEmail]
        ])->paginate($perPage);

        $rolesData = \Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get()->reverse()->values();
        $cities = \App\Models\City::all();

        return view('dashboard.users.index', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'usersData', 'rolesData', 'cities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $menuTitle = $user->name;
        $person = $user->profile;
        $rolesData = Role::where('name', '!=', 'Super Admin')->get();
        if ($user->profile->has_family) {
            $allPersons = \App\Models\Person::where('family_id', null)->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);
        } else {
            $allPersons = [];
        }
        $fosterPersons = \App\Models\Person::get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);

        return view('dashboard.users.show', compact('appMenu', 'menuTitle', 'pageTitle', 'user', 'person', 'rolesData', 'allPersons', 'fosterPersons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (is_null($user)) {
            return back()->with('error', 'حدث خطأ!');
        }

        $user->status = 'blocked';
        $user->save();

        \App\Helpers\AppHelper::AddLog('Block User', class_basename($user), $user->id);

        return back()->with('success', 'تم حظر المستخدم بنجاح');
    }

    /**
     * activate the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request)
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            return back()->with('error', 'حدث خطأ!');
        }

        if ($request->has('type') && $request->type == 'delete') {
            $user->status = 'blocked';
            \App\Helpers\AppHelper::AddLog('Block User', class_basename($user), $user->id);
            $user->save();
            return back()->with('error', 'تم حظر المستخدم بنجاح');
        } else {
            $user->status = 'active';
            \App\Helpers\AppHelper::AddLog('Activate User', class_basename($user), $user->id);
            $user->save();

            return back()->with('success', 'تم تنشيط حساب المستخدم بنجاح');
        }
    }

    // update user role
    public function roleAssign(Request $request)
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            return back()->with('error', 'حدث خطأ!');
        }

        $user->removeRole($user->role_id);
        $user->assignRole($request->role_id);
//        $user->syncRoles($request->role_id);
        $user->role_id = $request->role_id;
        $user->save();

        \App\Helpers\AppHelper::AddLog('Role User', class_basename($user), $user->id);

        return back()->with('warning', 'تم تعديل صلاحيات المستخدم بنجاح');
    }

    public function profile()
    {
        $menuTitle = 'القائمة الرئيسية';
        $pageTitle = 'الملف الشخصي';
        $user = auth()->user();
        $person = $user->profile;

        return view('auth.profile', compact('pageTitle', 'menuTitle', 'user', 'person'));
    }

    // update or add user to family
    public function updateFamily(Request $request)
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            return back()->with('error', 'حدث خطأ!');
        }

        $profile = $user->profile;
        $profile->family_id = $request->family_id;
        $profile->save();

        \App\Helpers\AppHelper::AddLog('Family User', class_basename($user), $user->id);
        return back()->with('warning', 'تم تعديل عائلة المستخدم بنجاح');
    }
    public function addFosterFamily(Request $request)
    {
        $person = Person::find($request->person_id);
        $foster_brother = FosterBrother::where('person_id', $request->person_id)
                                        ->where('family_id', $request->family_id)
                                        ->first();

        if (is_null($person)) {
            return back()->with('error', 'حدث خطأ!');
        }
        if ($person->family_id == $request->family_id) {
            return back()->with('error', 'هذاالفرد موجود في العائلة!');
        }
        if (!is_null($foster_brother) ) {
            return back()->with('error', 'الاخ في الرضاعة موجود بالفعل!');
        }
        $foster_brother = new FosterBrother;
        $foster_brother->family_id = $request->family_id;
        $foster_brother->person_id = $request->person_id;
        $foster_brother->save();

        \App\Helpers\AppHelper::AddLog('Family Foster Brother User', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }

    public function addNewFosterFamily(Request $request)
    {
        $person = new Person;
        $person->first_name = $request->first_name;
        $person->father_name = $request->father_name;
        $person->gender = $request->gender;
        $person->save();

        $foster_brother = FosterBrother::where('person_id', $person->id)
                                        ->where('family_id', $request->family_id)
                                        ->first();

        if (is_null($person)) {
            return back()->with('error', 'حدث خطأ!');
        }
        if ($person->family_id == $request->family_id) {
            return back()->with('error', 'هذاالفرد موجود في العائلة!');
        }
        if (!is_null($foster_brother) ) {
            return back()->with('error', 'الاخ في الرضاعة موجود بالفعل!');
        }
        $foster_brother = new FosterBrother;
        $foster_brother->family_id = $request->family_id;
        $foster_brother->person_id = $person->id;
        $foster_brother->save();

        \App\Helpers\AppHelper::AddLog('Family Foster Brother User', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }
}

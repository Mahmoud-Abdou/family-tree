<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\FosterBrother;
use App\Models\Person;
use App\Models\Family;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;


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
        $this->middleware('permission:users.update_user')->only('update_user');

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
        // $usersData = Person::leftJoin('users', 'persons.user_id', 'users.id')
        // //     ->where([
        // //     ['users.city_id', $perCity ? '=' : '<>', $perCity],
        // //     ['users.role_id', $perRole ? '=' : '<>', $perRole],
        // //     ['users.status', $perStatus ? '=' : '<>', $perStatus],
        // //     ['users.mobile', $perMobile ? '=' : '<>', $perMobile],
        // //     ['users.email', $perEmail ? '=' : '<>', $perEmail]
        // // ])
        // ->where('persons.user_id')
        // ->get();
        $usersData = Person::with('user')//->get()
        // ->select('users.*','persons.first_name', 'persons.id as person_id')
        ->paginate($perPage);

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
        $appMenu = config('custom.app_menu');
        $menuTitle = 'إضافة مستخدم';
        $pageTitle = 'لوحة التحكم';

        $female = Person::where('gender', 'female')
                        ->where('has_family', 0)
                        ->get();

        $persons = \App\Models\Person::where('has_family', 1)
                                        ->where('gender', 'male')
                                        ->get();

        $mothers = Person::where('gender', 'female')
                        ->where('has_family', 1)
                        ->get();

        $roles = \Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get()->reverse()->values();
        $cities = \App\Models\City::all();

        return view('dashboard.users.create', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'roles', 'cities', 'female', 'persons', 'mothers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if(!isset($request['is_alive'])){
            $request['is_alive'] = 'off';
        }
        if($request['gender'] == 'female'){
            $request['has_family'] = 'false';
        }
        $father = Person::where('id', $request->father_id)->first();
        $family = Family::where('father_id', $request->father_id)
                        ->where('mother_id', $request->mother_id)
                        ->first();

        if($family == null){
            return redirect()->back()->with('error', 'هناك مشكلة في العائلة');
        }
        $person = Person::create([
            'first_name' => $request->name,
            'father_name' => $father->first_name,
            'has_family' => $request->has_family == "true",
            'family_id' => $family->id,
            'gender' => $request->gender,
            'is_live' => $request->is_alive == 'off',
            'death_date' => $request->death_date,
        ]);

        if($request['has_family'] == 'true' && $request['gender'] == 'male'){
            if($request['wife_id'] == 'add'){
                $request->validate([
                    'partner_first_name' => ['required'],
                    'partner_father_name' => ['required'],
                    'partner_gender' => ['required', 'confirmed', Rule::in(['male', 'female'])],
                ]);
                if(!isset($request['partner_is_alive'])){
                    $request['partner_is_alive'] = 'off';
                }
                $wife = new Person;
                $wife->first_name = $request->partner_first_name;
                $wife->father_name = $request->partner_father_name;
                $wife->grand_father_name = $request->partner_grand_father_name;
                $wife->surname = $request->partner_surname;
                $wife->gender = $request->partner_gender;
                $wife->has_family = 1;
                $wife->is_live = $request->partner_is_alive == 'off';
                $wife->save();
                $wife_id = $wife->id;
            }
            else{
                $wife = Person::where('id', $request['wife_id'])->first();
                $wife->has_family = 1;
                $wife->save();
                $wife_id = $request['wife_id'];
            }
            Family::create([
                'name' => ' عائلة ' . ($person->first_name),
                'father_id' => $person->id,
                'mother_id' => $wife_id,
                'gf_family_id' => $family->id,
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'تم اضافة الشخص بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($person_id)
    {
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $person = Person::where('id', $person_id)->first();
        $menuTitle = $person->full_name;
        $user = $person;
        $rolesData = Role::where('name', '!=', 'Super Admin')->get();
        if ($person->has_family) {
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
    public function edit($person_id)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل المستخدم';
        $pageTitle = 'لوحة التحكم';
        // dd($person_id);
        $person = Person::where('id', $person_id)->first();
        return view('dashboard.users.update', compact('appMenu', 'menuTitle', 'pageTitle', 'person'));

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

    public function addNewPerson(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->orWhere('mobile', $request->mobile)
                    ->first();
        if($user != null){
            return back()->with('error', 'هذاالفرد موجود !');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => '123456789',
            'accept_terms' => 1,
            'status' => 'registered',
        ]);

        $person = Person::create([
            'user_id' => $user->id,
            'first_name' => $request->name,
            'father_name' => auth()->user()->profile->first_name,
            'has_family' => 0,
            'family_id' => $request['family_id'],
            'gender' => $request->gender,
        ]);


        \App\Helpers\AppHelper::AddLog('New User', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }

    public function update_user(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'person_id' => ['required', 'exists:persons,id'],
        ]);

        $person = Person::where('id', $request['person_id'])->first();
        $person->first_name = $request['name'];
        if(isset($request['is_alive'])){
            $person->is_live = 0;
            $person->death_date = $request['death_date'];
        }
        else
            $person->is_live = 1;
        $person->save();
        return back()->with('success', 'تم تعديل المستخدم بنجاح');

    }
}

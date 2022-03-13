<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\FosterBrother;
use App\Models\Person;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

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
        $this->middleware('permission:users.update')->only(['edit', 'update', 'roleAssign', 'update_user']);
        $this->middleware('permission:users.delete')->only('destroy');
        $this->middleware('permission:users.activate')->only('activate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'المستخدمين';
        $pageTitle = 'لوحة التحكم';

        $perPage = isset($request['filters']) ? $request['filters']['perPage'] : 10;
        // $perCity = isset($_GET['city']) && $_GET['city'] != 'all' ? $_GET['city'] : null;
        // $perRole = isset($_GET['role']) && $_GET['role'] != 'all' ? $_GET['role'] : null;
        // $perStatus = isset($_GET['status']) && $_GET['status'] != 'all' ? $_GET['status'] : null;
        // $perMobile = isset($_GET['mobile']) ? $_GET['mobile'] : null;
        // $perEmail = isset($_GET['email']) ? $_GET['email'] : null;

        $persons = new Person;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $persons->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $persons = $persons->filter($filters);
        $usersData = $persons->paginate($perPage);
        $cities = \App\Models\City::all();

        if (auth()->user()->hasRole('Super Admin')) {
            $rolesData = \Spatie\Permission\Models\Role::all()->reverse()->values();
        } else {
            $rolesData = \Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get()->reverse()->values();
        }

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
            ->where('has_family', 0)->get();

        $male = Person::where('gender', 'male')
            ->where('has_family', 0)->get();

        $persons = \App\Models\Person::where('has_family', 1)
            ->where('gender', 'male')->get();

        $mothers = Person::where('gender', 'female')
            ->where('has_family', 1)->get();

        return view('dashboard.users.create', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'female', 'persons', 'mothers', 'male'
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
        $family = null;
        if($request->type == 'withFamily'){

            if(!isset($request['is_alive'])){
                $request['is_alive'] = 'off';
            }

            if($request['gender'] == 'female'){
                $request['has_family'] = 'false';
            }

            $father = Person::where('id', $request->father_id)->first();
            if($father == null){
                $father_name = explode(' ', $request->father_id);
                $father = Person::create([
                    'first_name' => $father_name[0],
                    'father_name' => isset($father_name[1]) ? $father_name[1] : ' ',
                    'grand_father_name' => isset($father_name[2]) ? $father_name[2] : null,
                    'has_family' => 1,
                    'gender' => 'male',
                    'is_live' => $request->is_alive == 'off',
                    'death_date' => $request->death_date,
                ]);
                $request->father_id = $father->id;
            }

            if($request->mother_id == 'none'){
                $family = Family::create([
                    'name' => ' عائلة ' . ($father->first_name),
                    'father_id' => $father->id,
                    'mother_id' => null,
                ]);
            }else{
                $mother = Person::where('id', $request->mother_id)->first();
                if($mother == null){
                    $mother_name = explode(' ', $request->mother_id);
                    $mother = Person::create([
                        'first_name' => $mother_name[0],
                        'father_name' => isset($mother_name[1]) ? $mother_name[1] : $father->father_name,
                        'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                        'has_family' => 1,
                        'gender' => 'female',
                        'is_live' => $request->is_alive == 'off',
                        'death_date' => $request->death_date,
                    ]);
                    $family = Family::create([
                        'name' => ' عائلة ' . ($father->first_name),
                        'father_id' => $father->id,
                        'mother_id' => $mother->id,
                    ]);
                    $request->mother_id = $mother->id;
                }
                $mother->has_family = 1;
                $mother->save();
                $family = Family::where('father_id', $request->father_id)
                    ->where('mother_id', $request->mother_id)
                    ->first();
            }

            if($family == null){
                return redirect()->back()->with('error', 'هناك مشكلة في العائلة');
            }
            $family = Family::where('id', $family->id)->first();


            $childern = (int)$family->children_count;
            $family->children_count = $childern + 1;
            $family->save();

            $person = Person::create([
                'first_name' => $request->name,
                'father_name' => $father->first_name,
                'has_family' => $request->has_family == "true",
                'family_id' => $family->id,
                'gender' => $request->gender,
                'is_live' => $request->is_alive == 'off',
                'death_date' => $request->death_date,
                'death_place' => $request->death_place,
                'surname' => $request->surname,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'job' => $request->job,
            ]);

            if($request['has_family'] == 'true' && $request['gender'] == 'male'){
                $collectionOld = collect($person->ownFamily->pluck('id'));
                $collectionNew = collect($request['wife_id']);

                $deleteItems = $collectionOld->diff($collectionNew);
                foreach ($deleteItems as $oldFamily) {
                    $fam = Family::where('id', $oldFamily)->first();
                    foreach ($fam->members as $famMember) {
                        $famMember->family_id = null;
                        $famMember->save();
                    }
                    if(isset($fam->mother)){
                        $fam->mother->has_family = 0;
                        $fam->mother->save();
                    }
                    $fam->delete();
                }

                foreach($request['wife_id'] as $row_wife_id){
                    if($row_wife_id == 'add'){
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
                    elseif($row_wife_id == 'none'){
                        $wife_id = null;
                    }
                    else{
                        $wife = Person::where('id', $row_wife_id)->first();
                        if($wife == null){
                            $mother_name = explode(' ', $row_wife_id);
                            $wife = Person::create([
                                'first_name' => $mother_name[0],
                                'father_name' => isset($mother_name[1]) ? $mother_name[1] : $father->father_name,
                                'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                                'has_family' => 1,
                                'gender' => 'female',
                                'is_live' => $request->is_alive == 'off',
                                'death_date' => $request->death_date,
                            ]);
                        }
                        $wife->has_family = 1;
                        $wife->save();
                        $wife_id = $wife->id;
                    }
                    Family::create([
                        'name' => ' عائلة ' . ($person->first_name),
                        'father_id' => $person->id,
                        'mother_id' => $wife_id,
                        'gf_family_id' => $family->id,
                    ]);
                }
            }
            elseif($request['gender'] == 'male'){
                $collectionOld = collect($person->ownFamily->pluck('id'));
                $collectionNew = [];

                $deleteItems = $collectionOld->diff($collectionNew);
                foreach ($deleteItems as $oldFamily) {
                    $fam = Family::where('id', $oldFamily)->first();
                    foreach ($fam->members as $famMember) {
                        $famMember->family_id = null;
                        $famMember->save();
                    }
                    if(isset($fam->mother)){
                        $fam->mother->has_family = 0;
                        $fam->mother->save();
                    }
                    $fam->delete();
                }
            }
        }
        else{
            if(!isset($request['no_family_is_alive'])){
                $request['no_family_is_alive'] = 'off';
            }
            $person = Person::create([
                'first_name' => $request->name,
                'father_name' => $request->father_name,
                'grand_father_name' => $request->grand_father_name,
                'has_family' => $request->has_family == 'true',
                'gender' => 'male',
                'is_live' => $request->no_family_is_alive == 'off',
                'death_date' => $request->no_family_death_date,
                'death_place' => $request->no_family_death_place,
                'surname' => $request->no_family_surname,
                'birth_date' => $request->no_family_birth_date,
                'birth_place' => $request->no_family_birth_place,
                'job' => $request->no_family_job,
            ]);
            if($request->has_family == 'true'){
                $wife = Person::create([
                    'first_name' => 'زوجة' . $request->name,
                    'father_name' => $request->father_name,
                    'has_family' => 1,
                    'gender' => 'female',
                    'is_live' => $request->no_family_is_alive == 'off',
                    'death_date' => $request->no_family_death_date,
                ]);

                Family::create([
                    'name' => ' عائلة ' . ($person->first_name),
                    'father_id' => $person->id,
                    'mother_id' => $wife->id,
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'تم اضافة الشخص بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($person_id)
    {
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $person = Person::where('id', $person_id)->first();
        $menuTitle = $person->full_name;
        $user = $person;
        $rolesData = Role::where('name', '!=', 'Super Admin')->get();

        $allPersons = [];
        if ($person->has_family) {
            $allPersons = \App\Models\Person::get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);
        }
        $fosterPersons = \App\Models\Person::get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);

        return view('dashboard.users.show', compact('appMenu', 'menuTitle', 'pageTitle', 'user', 'person', 'rolesData', 'allPersons', 'fosterPersons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($person_id)
    {
        $person = Person::where('id', $person_id)->first();
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل المستخدم: '.$person->first_name;
        $pageTitle = 'لوحة التحكم';

        $wives = $person->wives->pluck('id');
        $children = $person->children->pluck('id');
        $female = Person::where('gender', 'female')
            ->where(function ($q) use ($wives) {
                $q->where('has_family', 0)->orWhereIn('id', $wives);
            })
            ->WhereNotIn('id', $children)
            ->get();

        $male = Person::where('gender', 'male')
            ->WhereNotIn('id', $children)
            ->get();

        $persons = \App\Models\Person::where('has_family', 1)
            ->where('gender', 'male')->get();

        $mothers = Person::where('gender', 'female')
            ->where('has_family', 1)->get();

        return view('dashboard.users.update', compact('appMenu', 'menuTitle', 'pageTitle', 'person', 'female', 'persons', 'mothers', 'male'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $person = Person::findOrFail($request->person_id);
        if (!isset($person)) {
            return back()->with('error', 'توجد مشكلة في تعديل بيانات الشخص.');
        }
        if($person->family_id != null){
            $father = Person::find($request->father_id);
            $mother = Person::find($request->mother_id);
            
            if(isset($father->id) && isset($mother->id)){
                $MainFamily = Family::where('father_id', $father->id)->where('mother_id', $mother->id)->first();
                if($MainFamily == null){
                    return back()->with('error', 'توجد مشكلة في   العائلة.');
                }
            }
            if (!isset($father)) {
                $father_name = explode(' ', $request->father_id);
                $father = Person::create([
                    'first_name' => $father_name[0],
                    'father_name' => isset($father_name[1]) ? $father_name[1] : '',
                    'grand_father_name' => isset($father_name[2]) ? $father_name[2] : null,
                    'surname' => isset($father_name[3]) ? $father_name[3] : null,
                    'has_family' => 1,
                    'gender' => 'male',
                    'is_live' => $request->is_alive == 'off',
                    'death_date' => null,
                ]);
            }

            if (!isset($mother)) {
                $mother_name = explode(' ', $request->mother_id);
                $mother = Person::create([
                    'first_name' => $mother_name[0],
                    'father_name' => isset($mother_name[1]) ? $mother_name[1] : '',
                    'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                    'surname' => isset($mother_name[3]) ? $mother_name[3] : null,
                    'has_family' => 1,
                    'gender' => 'female',
                    'is_live' => $request->is_alive == 'off',
                    'death_date' => null,
                ]);
            }
            $grandFamily = Family::where('father_id', $father->id)->where('mother_id', $mother->id)->first();

            if (!isset($grandFamily)) {
                $grandFamily = Family::create([
                    'name' => ' عائلة ' . $father->first_name,
                    'father_id' => $father->id,
                    'mother_id' => $mother->id,
                    'gf_family_id' => isset($father->family_id) ? $father->family_id : null,
                ]);
            }
        }
        $request['has_family'] = $request->has('has_family') ? $request->has_family : "false";

        if($request['has_family'] == 'true' && $request['gender'] == 'male'){
            if ($request->has('wife_id') && count($request['wife_id']) > 0) {
                // delete old families
                $collectionOld = collect($person->ownFamily->pluck('id'));
                $collectionNew = collect($request['wife_id']);

                $deleteItems = $collectionOld->diff($collectionNew);
                // $newItems = $collectionNew->diff($collectionOld);
                foreach ($deleteItems as $oldFamily) {
                    $fam = Family::where('id', $oldFamily)->first();
                    foreach ($fam->members as $famMember) {
                        $famMember->family_id = null;
                        $famMember->save();
                    }

                    if(isset($fam->mother)){
                        $fam->mother->has_family = 0;
                        $fam->mother->save();
                    }
                    $fam->delete();
                }
                // end delete old families
                foreach($request['wife_id'] as $row_wife_id){
                    $wife = Person::where('id', $row_wife_id)->first();
                    if($wife == null){
                        $mother_name = explode(' ', $row_wife_id);
                        $wife = Person::create([
                            'first_name' => $mother_name[0],
                            'father_name' => isset($mother_name[1]) ? $mother_name[1] : '',
                            'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                            'surname' => isset($mother_name[3]) ? $mother_name[3] : null,
                            'has_family' => 1,
                            'gender' => 'female',
                            'is_live' => $request->is_alive == 'off',
                            'death_date' => null,
                        ]);
                    } else {
                        $wife->has_family = true;
                        $wife->save();

                        $family = Family::where('father_id', $person->id)->where('mother_id', $wife->id)->first();
                        if (isset($family)) {
                            $family->children_count = $family->members->count();
                            $family->save();
                        }
                    }

                    $family = Family::create([
                        'name' => ' عائلة ' . $person->first_name,
                        'father_id' => $person->id,
                        'mother_id' => $wife->id,
                        'gf_family_id' => isset($grandFamily) ? $grandFamily->id : null,
                    ]);

                    $family->children_count = $family->members->count();
                    $family->save();
                }
            } else {
                $collectionOld = collect($person->ownFamily->pluck('id'));
                $collectionNew = [];

                $deleteItems = $collectionOld->diff($collectionNew);
                // $newItems = $collectionNew->diff($collectionOld);
                foreach ($deleteItems as $oldFamily) {
                    $fam = Family::where('id', $oldFamily)->first();
                    foreach ($fam->members as $famMember) {
                        $famMember->family_id = null;
                        $famMember->save();
                    }

                    if(isset($fam->mother)){
                        $fam->mother->has_family = 0;
                        $fam->mother->save();
                    }
                    $fam->delete();
                }
                // $wife = null;
                Family::create([
                    'name' => ' عائلة ' . $person->first_name,
                    'father_id' => $person->id,
                    'mother_id' => null,
                    'gf_family_id' => isset($grandFamily) ? $grandFamily->id : null,
                ]);
            }
        }
        else if($request['gender'] == 'male'){
            $collectionOld = collect($person->ownFamily->pluck('id'));
            $collectionNew = [];

            $deleteItems = $collectionOld->diff($collectionNew);
            foreach ($deleteItems as $oldFamily) {
                $fam = Family::where('id', $oldFamily)->first();
                foreach ($fam->members as $famMember) {
                    $famMember->family_id = null;
                    $famMember->save();
                }
                if(isset($fam->mother)){
                    $fam->mother->has_family = 0;
                    $fam->mother->save();
                }
                $fam->delete();
            }
        }

        $person->first_name = $request->first_name;
        $person->father_name = isset($father) ? $father->first_name : $request['father_name'];
        $person->grand_father_name = isset($father) ? $father->father_name : $request['grand_father_name'];
        $person->surname = $request->surname;
        $person->gender = $request->gender;
        $person->has_family = $request->has_family == 'true';
        $person->is_live = $request->is_alive != 'on';
        $person->death_date = $request->death_date;
        $person->death_place = $request->death_place;
        $person->birth_date = $request->birth_date;
        $person->birth_place = $request->birth_place;
        $person->family_id = isset($grandFamily) ? $grandFamily->id : null;

        if ($person->isDirty()) {
            $person->save();

            AppHelper::AddLog('Update Person', class_basename($person), $person->id);
            return back()->with('success', 'تم تعديل بيانات المستخدم بنجاح');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $person = Person::findOrFail(request()->person_id);

        if (is_null($person)) {
            return back()->with('error', 'حدث خطأ!');
        }

        // if (auth()->id() == $person->user->id) {
        //     return back()->with('error', 'لا يمكنك حذف هذا المستخدم!');
        // }

        if ($person->has_family) {
            foreach ($person->ownFamily as $f) {
                foreach ($f->members as $m) {
                    $m->family_id = null;
                    $m->save();
                }
                if (isset($f->mother)) {
                    $f->mother->has_family = 0;
                    $f->mother->save();
                }
                $f->delete();
            }
        }
        if (isset($person->user)) {
            $person->user->delete();
        }

        AppHelper::AddLog('Person Delete', class_basename($person), $person->id);
        $person->delete();
        return back()->with('success', 'تم حذف الشخص بنجاح');
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
            AppHelper::AddLog('Block User', class_basename($user), $user->id);
            $user->save();
            return back()->with('error', 'تم حظر المستخدم بنجاح');
        } else {
            $user->status = 'active';
            AppHelper::AddLog('Activate User', class_basename($user), $user->id);
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
        // $user->syncRoles($request->role_id);
        $user->role_id = $request->role_id;
        $user->save();

        AppHelper::AddLog('Role User', class_basename($user), $user->id);
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
        $family = Family::where('id', $request->family_id)->first();
        if (is_null($family)) {
            return back()->with('error', 'حدث خطأ!');
        }

        if (isset($request->users)) {
            foreach ($request->users as $children) {
                $child = Person::find($children);
                $child->family_id = $family->id;
                $child->save();
            }
        }

        $family->children_count = (int)$family->children_count + 1;
        $family->save();

        AppHelper::AddLog('Family User', class_basename($family), $family->id);
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

        AppHelper::AddLog('Family Foster Brother User', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }

    public function addNewFosterFamily(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'father_name' => ['required'],
            'gender' => ['required'],
        ]);

        $person = new Person;
        $person->first_name = $request->first_name;
        $person->father_name = $request->father_name;
        $person->grand_father_name = $request->grand_father_name;
        $person->surname = $request->surname;
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

        AppHelper::AddLog('Foster Brother User', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }

    public function addNewPerson(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'gender' => ['required'],
        ]);

        $family = Family::findOrFail($request->family_id);

        if (!isset($family)) {
            return back()->with('error', 'حدثت مشكلة.');
        }

        $person = Person::create([
            'user_id' => null,
            'first_name' => $request->name,
            'father_name' => $family->father->first_name,
            'grand_father_name' => $family->father->father_name,
            'surname' => $family->father->grand_father_name,
            'has_family' => 0,
            'family_id' => $family->id,
            'gender' => $request->gender,
        ]);

        $family->children_count = (int)$family->children_count + 1;
        $family->save();

        AppHelper::AddLog('Add Person', class_basename($person), $person->id);
        return back()->with('success', 'تم تعديل عائلة المستخدم بنجاح');
    }

    // update person and relations
    public function update_user(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'person_id' => ['required', 'exists:persons,id'],
        ]);
        $person = Person::where('id', $request['person_id'])->first();

        if(isset($request['father_id'])){
            $father = Person::where('id', $request['father_id'])->first();
            if($father == null){
                $father_name = explode(' ', $request->father_id);
                $father = Person::create([
                    'first_name' => $father_name[0],
                    'father_name' => isset($father_name[1]) ? $father_name[1] : ' ',
                    'grand_father_name' => isset($father_name[2]) ? $father_name[2] : null,
                    'has_family' => 1,
                    'gender' => 'male',
                ]);
            }

            if (isset($person->belongsToFamily)) {
                $person->belongsToFamily->father_id = $father->id;
                $person->belongsToFamily->save();
            } else {
                $person->family_id = $father->family->id;;
                $person->save();
            }
        }
        if(isset($request['mother_id'])){
            $mother = Person::where('id', $request['mother_id'])->first();
            if($mother == null){
                if($request->mother_id == 'none'){
                    if (isset($person->belongsToFamily)) {
                        $person->belongsToFamily->mother_id = null;
                        $person->belongsToFamily->save();
                    }
                }
                else{
                    $mother_name = explode(' ', $request->mother_id);
                    $mother = Person::create([
                        'first_name' => $mother_name[0],
                        'father_name' => isset($mother_name[1]) ? $mother_name[1] : $father->father_name,
                        'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                        'has_family' => 1,
                        'gender' => 'female',
                        'is_live' => $request->is_alive == 'off',
                        'death_date' => $request->death_date,
                    ]);

                    if (isset($person->belongsToFamily)) {
                        $person->belongsToFamily->mother_id = $mother->id;
                        $person->belongsToFamily->save();
                    } else {
                        $person->family_id = $mother->family->id;;
                        $person->save();
                    }
                }
            }
            else{
                if(!isset($person->mother) || $person->mother->id != $request['mother_id']){
                    if(isset($person->mother)){
                        $person->mother->has_family = 0;
                        $person->mother->save();
                    }

                    $person->belongsToFamily->mother_id = $request['mother_id'];
                    $person->belongsToFamily->save();
                }
            }
        }

        if($request['has_family'] == 'true') {
            if (isset($person->wives)) {
                foreach ($person->wives as $row_person_wife) {
                    $test = 0;
                    foreach ($request['wife_id'] as $row_wife_id) {
                        if ($row_wife_id == $row_person_wife->id) {
                            $test = 1;
                        }
                    }
                    if ($test == 0) {
                        $row_person_wife->has_family = 1;
                        $row_person_wife->save();


                        $wife_family = Family::where('mother_id', $row_person_wife->id)
                            ->where('father_id', $person->id)
                            ->first();

                        if ($wife_family != null) {
                            $childern = Person::where('family_id', $wife_family->id);
                            $childern->update(['family_id' => null]);

                            $wife_family->delete();
                        }
                    }
                }
            }

            if (isset($request['wife_id'])) {
                foreach ($request['wife_id'] as $row_wife_id) {
                    if ($row_wife_id == 'none') {
                        $wife_id = null;
                    } else {
                        $wife = Person::where('id', $row_wife_id)->first();
                        if ($wife == null) {
                            $mother_name = explode(' ', $row_wife_id);
                            $wife = Person::create([
                                'first_name' => $mother_name[0],
                                'father_name' => isset($mother_name[1]) ? $mother_name[1] : $person->father_name,
                                'grand_father_name' => isset($mother_name[2]) ? $mother_name[2] : null,
                                'has_family' => 1,
                                'gender' => 'female',
                                'is_live' => $request->is_alive == 'off',
                                'death_date' => $request->death_date,
                            ]);
                        }
                        $wife->has_family = 1;
                        $wife->save();
                        $wife_id = $wife->id;
                    }
                    $family = Family::where('father_id', $person->id)
                        ->where('mother_id', $wife_id)
                        ->first();
                    if ($family == null || $wife_id == null) {
                        Family::create([
                            'name' => ' عائلة ' . ($person->first_name),
                            'father_id' => $person->id,
                            'mother_id' => $wife_id,
                        ]);
                    }
                }
            } else {
                $wife_id = null;
            }
        }

        $person->first_name = $request['first_name'];
        $person->surname = $request['surname'];
        $person->birth_date = $request['birth_date'];
        $person->birth_place = $request['birth_place'];
        $person->job = $request['job'];
        if(isset($request['is_alive'])){
            $person->is_live = 0;
            $person->death_date = $request['death_date'];
            $person->death_place = $request['death_place'];
        }
        else
            $person->is_live = 1;
            $person->save();
        if(isset($person->user)){
            $request->validate([
                'email' => ['required'],
                'mobile' => ['required'],
            ]);
            $user = $person->user;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->name = $request->first_name;
            $user->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'تم تعديل المستخدم بنجاح');
    }

    public function add_person_user(Request $request)
    {
        $request->validate([
            'person_id' => ['required', 'exists:persons,id'],
            'email' => ['required'],
            'mobile' => ['required'],
        ]);

        $person = Person::where('id', $request->person_id)->first();

        $user = new User;
        $user->name = $person->first_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = '123456789';
        $user->save();

        $person->user_id = $user->id;
        $person->save();

        return back()->with('success', 'تم انشاء المستخدم بنجاح');
    }

}

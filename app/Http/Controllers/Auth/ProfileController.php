<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePersonRequest;
use App\Rules\PasswordRule;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\Person;
use App\Models\User;


class ProfileController extends Controller
{
    use hasImage;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $menuTitle = 'الملف الشخصي';
        $pageTitle = 'القائمة الرئيسية';
        $user = auth()->user();
        $person = $user->profile;
        if(auth()->user()->profile->gender == 'female'){
            if(!isset(auth()->user()->profile->wifeOwnFamily)){
                return redirect()->back()->with('error', 'حدث خطا');
            }
            $husband_id = auth()->user()->profile->wifeOwnFamily->father_id;
        }
        else{
            $husband_id = auth()->user()->profile->id;
        }

        $wives_ids = Family::where('father_id', $husband_id)->pluck('mother_id');
        $wives_ids[] = $husband_id;
        if ($user->profile->has_family) {
            $allPersons = \App\Models\Person::where('family_id', null)
                                            ->whereNotIn('id', $wives_ids)
                                            ->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);
        } else {
            $allPersons = [];
        }
        $fosterPersons = \App\Models\Person::get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);


        if ($person->completeData() > 1) {
            session()->flash('warning', 'الملف الشخصي غير مكتمل، يجب استكمال البيانات.');
        }
        return view('auth.profile', compact('menuTitle', 'pageTitle', 'user', 'person', 'allPersons', 'fosterPersons'));
    }

    public function edit()
    {
        $menuTitle = 'تعديل الملف الشخصي';
        $pageTitle = 'القائمة الرئيسية';
        $user = auth()->user();
        $person = $user->profile;
        $husband_id = $person->id;

        $family_ids = Family::where('father_id', $husband_id)->pluck('id');

        $female = Person::where('is_live', 1)
                        ->where('gender', 'female')
                        ->where('has_family', 0)
                        ->whereNotIn('family_id', $family_ids)
                        ->get();
        return view('auth.profile-update', compact('menuTitle', 'pageTitle', 'user', 'person', 'female'));
    }

    public function update(UpdatePersonRequest $request)
    {
        $person = auth()->user()->profile;

        $request['has_family'] = $request->has_family == "true";
        $person->update($request->all());

        if($request->wife_id == 'add'){
            $partner_person = User::where('email', $request['partner_email'])->orWhere('mobile', $request['partner_mobile'])->first();

            if ($partner_person == null) {
                $partner_user = User::create([
                    'name' => $request->partner_first_name,
                    'email' => $request->partner_email,
                    'mobile' => $request->partner_mobile,
                    'password' => '123456789',
                    'accept_terms' => 1,
                    'status' => 'registered'
                ]);

                $partner_person = Person::create([
                    'user_id' => $partner_user->id,
                    'first_name' => $request->partner_first_name,
                    'father_name' => $request->partner_father_name,
                    'has_family' => 1,
                    'gender' => 'female',
                ]);
            }

            Family::create([
                'name' => ' عائلة ' . ($person->first_name),
                'father_id' => $person->id,
                'mother_id' => $partner_person->id,
                'gf_family_id' => $person->family_id,
            ]);
        }
        else{
            Family::create([
                'name' => ' عائلة ' . ($person->first_name),
                'father_id' => $person->id,
                'mother_id' => $request->wife_id,
                'gf_family_id' => $person->family_id,
            ]);
        }

        if ($request->hasfile('photo')) {
            if (file_exists(public_path($person->photoPath) . $person->getRawOriginal('photo'))) {
                unlink(public_path($person->photoPath) . $person->getRawOriginal('photo'));
            }

            $person->photo = $this->ImageUpload($request->file('photo'), $person->photoPath);
        } else if($request->remove_photo == "true"){
            $person->photo = 'default.png';
        }

        if ($person->isDirty()) {
            $person->save();
        }

        return redirect()->route('profile')->with('success', 'تم تحديث بيانات الملف الشخصي بنجاح.');
    }

    public function updateUser(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'mobile' => ['required', 'numeric', 'unique:users,mobile,'.$user->id],
        ]);

        if (isset($request->password)) {
            $request->validate([
                'password' => ['required', 'confirmed', PasswordRule::defaults()],
            ]);
            $user->password = $request->password;
        }



        $user->mobile = $request->mobile;
        $user->email = $request->email;

        if ($user->isDirty()) {
            $user->save();

            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('home');
        }

        return redirect()->route('profile');
    }

    public function historyDelete()
    {
        auth()->user()->history->each(function($history){
            $history->delete();
        });
    }
}

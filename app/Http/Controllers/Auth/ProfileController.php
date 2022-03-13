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
        $allPersons = [];
        if ($user->profile->has_family) {
            $allPersons = \App\Models\Person::where('family_id', null)
                ->whereNotIn('id', $wives_ids)
                ->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);
        }

        if ($person->completeData() > 1) {
            session()->flash('warning', 'الملف الشخصي غير مكتمل، يجب استكمال البيانات.');
        }
        return view('auth.profile', compact('menuTitle', 'pageTitle', 'user', 'person', 'allPersons'));
    }

    public function edit()
    {
        $menuTitle = 'تعديل الملف الشخصي';
        $pageTitle = 'القائمة الرئيسية';
        $user = auth()->user();
        $person = $user->profile;

        $family_ids = Family::where('father_id', $person->id)->pluck('id');
        
        $female = Person::where('gender', 'female')
            // ->where('has_family', 0)
            // ->whereNotIn('family_id', $family_ids)
            ->get();
        // dd($family_ids);
        $males = Person::where('gender', 'male')
            // ->where('has_family', 0)
            // ->whereNotIn('family_id', $family_ids)
            ->get();

        return view('auth.profile-update', compact('menuTitle', 'pageTitle', 'user', 'person', 'female', 'males'));
    }

    public function update(UpdatePersonRequest $request)
    {
        $person = auth()->user()->profile;
        $request['has_family'] = $request->has_family == "true";
        $person->update($request->all());

        if ($request['has_family'] && $request['gender'] == 'male') {
            if ($request->has('wife_id') && count($request->wife_id) > 0) {
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
                foreach ($request->wife_id as $wif) {
                    $partner_person = Person::find($wif);

                    if (!$person->wives->contains('id', $wif)) {
                        if (!isset($partner_person)) {
                            if (!isset($request->partner_first_name) || !isset($request->partner_father_name)) {
                                return back()->with('error', 'لم يتم اضافاة بيانات الزوجة!');
                            }

                            if ($request->partner_email && $request->partner_mobile) {
                                $partner_user = User::create([
                                    'name' => $request->partner_first_name,
                                    'email' => $request->partner_email,
                                    'mobile' => $request->partner_mobile,
                                    'password' => '123456789',
                                    'accept_terms' => 1,
                                    'status' => 'registered'
                                ]);
                            }

                            $partner_person = Person::create([
                                'user_id' => isset($partner_user) ? $partner_user->id : null,
                                'first_name' => $request->partner_first_name,
                                'father_name' => $request->partner_father_name,
                                'grand_father_name' => $request->partner_grand_father_name,
                                'surname' => $request->partner_surname,
                                'has_family' => 1,
                                'gender' => 'female',
                            ]);
                        }

                        $family = Family::where([['father_id', $person->id],['mother_id', $partner_person->id]])->first();
                        if (!isset($family)) {
                            $family = Family::create([
                                'name' => ' عائلة ' . $person->first_name,
                                'father_id' => $person->id,
                                'mother_id' => isset($partner_person) ? $partner_person->id : null,
                                'gf_family_id' => isset($person->family_id) ? $person->family_id : null,
                            ]);
                        }
                        $partner_person->has_family = 1;
                        $partner_person->save();

                        $family->children_count = $family->members->count();
                        $family->save();
                    }

                    foreach ($person->wives as $oldWif) {
                        if ($oldWif->id != $partner_person->id) {
                            $oldFamily = Family::where([['father_id', $person->id], ['mother_id', $oldWif->id]])->first();
//                            $oldFamily->mother_id = null;
                            $oldFamily->status = false;
                            $oldFamily->save();
                        }
                    }
                }
            } else {
                return back()->with('error', 'لم يتم اضافاة بيانات الزوجة!');
            }
        }

        if ($request['has_family'] && $request['gender'] == 'female') {
            $partner_person = Person::find($request->husband_id);

            if (!isset($partner_person)) {
                if (!isset($request->partner_first_name) || !isset($request->partner_father_name)) {
                    return back()->with('error', 'لم يتم اضافاة بيانات الزوج!');
                }

                if ($request->partner_email && $request->partner_mobile) {
                    $partner_user = User::create([
                        'name' => $request->partner_first_name,
                        'email' => $request->partner_email,
                        'mobile' => $request->partner_mobile,
                        'password' => '123456789',
                        'accept_terms' => 1,
                        'status' => 'registered'
                    ]);
                }

                $partner_person = Person::create([
                    'user_id' => isset($partner_user) ? $partner_user->id : null,
                    'first_name' => $request->partner_first_name,
                    'father_name' => $request->partner_father_name,
                    'grand_father_name' => $request->partner_grand_father_name,
                    'surname' => $request->partner_surname,
                    'has_family' => 1,
                    'gender' => 'male',
                ]);
            }

            $family = Family::where([['father_id', $partner_person->id],['mother_id', $person->id]])->first();
            if (!isset($family)) {
                $family = Family::create([
                    'name' => ' عائلة ' . $partner_person->first_name,
                    'father_id' => $partner_person->id,
                    'mother_id' => $person->id,
                    'gf_family_id' => isset($person->family_id) ? $person->family_id : null,
                ]);
            }

            $family->children_count = $family->members->count();
            $family->save();
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

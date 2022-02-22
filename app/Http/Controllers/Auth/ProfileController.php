<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePersonRequest;
use App\Rules\PasswordRule;
use App\Traits\HasImage;
use Illuminate\Http\Request;

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

        if ($user->profile->has_family) {
            $allPersons = \App\Models\Person::where('family_id', null)->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);
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

        return view('auth.profile-update', compact('menuTitle', 'pageTitle', 'user', 'person'));
    }

    public function update(UpdatePersonRequest $request)
    {
        $person = auth()->user()->profile;

        $request['has_family'] = $request->has_family == "true";
        $person->update($request->all());

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

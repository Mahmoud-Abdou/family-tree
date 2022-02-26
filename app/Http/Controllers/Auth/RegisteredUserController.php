<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Family;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Nette\Utils\Helpers;

//use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        if($request->terms != 'on') {
            return back()->with('error', __('يجب الموافقة على اتفاقية الاستخدام!'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'accept_terms' => $request->terms == 'on',
            'status' => AppHelper::GeneralSettings('app_registration') ? 'active' : 'registered', // or registered
        ]);

        $person = Person::create([
            'user_id' => $user->id,
            'first_name' => $user->name,
            'father_name' => $request->father_name,
            'has_family' => $request->has_family == '1',
            'gender' => $request->gender,
        ]);

        if($request->has_family == '1'){
            $partner_person = User::where('email', $request['partner_email'])->orWhere('mobile', $request['partner_mobile'])->first();

            if ($partner_person == null) {
                $partner_user = User::create([
                    'name' => $request->partner_first_name,
                    'email' => $request->partner_email,
                    'mobile' => $request->partner_mobile,
                    'password' => '123456789',
                    'accept_terms' => $request->terms == 'on',
                    'status' => 'registered'
                ]);

                $partner_person = Person::create([
                    'user_id' => $partner_user->id,
                    'first_name' => $request->partner_first_name,
                    'father_name' => $request->partner_father_name,
                    'has_family' => $request->gender == 'male' ? 0 : 1,
                    'gender' => $request->gender == 'male' ? 'female' : 'male',
                ]);
            }

            Family::create([
                'name' => ' عائلة ' . ($request->gender == 'male' ? $request->name : $request->partner_first_name),
                'father_id' => $request->gender == 'male' ? $person->id : $partner_person->id,
                'mother_id' => $request->gender == 'female' ? $person->id : $partner_person->id,
            ]);

        }

        $user->assignRole(AppHelper::GeneralSettings('default_user_role'));

        event(new Registered($user));

        AppHelper::AddLog('Register User', class_basename($user), $user->id);

        if(AppHelper::GeneralSettings('app_registration')) {
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }

        return redirect()->route('login')->with('warning', 'تم الاشتراك بنجاح، و سيتم تفعيل حسابكم قريباً..');
    }
}

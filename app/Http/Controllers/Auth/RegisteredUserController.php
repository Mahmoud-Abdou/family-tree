<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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
            return back()->with('error', __('يجب الموافقة على اتفاقية الاستخدام'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'accept_terms' => $request->terms == 'on',
            'status' => \App\Helpers\AppHelper::GeneralSettings('app_registration') ? 'active' : 'registered', // or registered
        ]);

        Person::create([
            'user_id' => $user->id,
            'first_name' => $user->name,
            'father_name' => $request->father_name,
            'gender' => $request->gender,
        ]);

        $user->assignRole(\App\Helpers\AppHelper::GeneralSettings('default_user_role'));

        event(new Registered($user));

        if(\App\Helpers\AppHelper::GeneralSettings('app_registration')) {
            Auth::login($user);
        }

        \App\Helpers\AppHelper::AddLog('Register User', class_basename($user), $user->id);

        return redirect(RouteServiceProvider::HOME)->with('success', 'تم الاشتراك بنجاح، و سيتم تفعيل حسابكم قريباً..');
    }
}

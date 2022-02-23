<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\FirstLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FirstAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (\App\Helpers\AppHelper::GeneralSettings('app_first_registration')){
            return view('auth.password-confirmation');
        }

        return redirect()->route('home');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\FirstLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FirstLoginRequest $request)
    {
        if (!\App\Helpers\AppHelper::GeneralSettings('app_first_registration')){
            return redirect()->route('home');
        }

        $user = User::where('email', $request->email)->first();
        if($user->status != 'registered'){
            throw ValidationException::withMessages([
                'message' => 'هذا الحساب مفعل !',
            ]);
        }
        $user->password = $request['password'];
        $user->status = 'active';
        $user->save();

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string'], // 'email' or 'mobile'
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
//        $credentials = $this->getCredentials();

        if (! Auth::attempt($this->getCredentials(), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if(auth()->user()->status != 'active') {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            redirect()->back()->with(['error' => __('auth.failed')]);
        } else {
            \App\Helpers\AppHelper::AddUserHistory();
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getCredentials()
    {
        // logging users in with both (mobile and email)
        // we have to check if user has entered one or another
        $email = $this->get('email');

        if (!$this->isEmail($email)) {
            return [
                'mobile' => $email,
                'password' => $this->get('password')
            ];
        }

        return $this->only('email', 'password');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }

    /**
     * Validate if provided parameter is valid email.
     *
     * @param $param
     * @return bool
     * @throws BindingResolutionException
     */
    private function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['email' => $param],
            ['email' => 'email']
        )->fails();
    }
}

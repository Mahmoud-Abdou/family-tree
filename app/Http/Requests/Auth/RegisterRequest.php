<?php

namespace App\Http\Requests\Auth;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'partner_email' => ['required_if:has_family,1'],
            'partner_first_name' => ['required_if:has_family,1'],
            'partner_father_name' => ['required_if:has_family,1'],
            'partner_mobile' => ['required_if:has_family,1'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'unique:users'],
        //    'mobile' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ];
    }
}

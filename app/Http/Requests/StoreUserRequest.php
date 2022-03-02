<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'father_id' => ['required', 'exists:persons,id'],
            'mother_id' => ['required', 'exists:persons,id'],
//            'wife_id' => ['required'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'has_family' => ['required'],
        ];
    }
}

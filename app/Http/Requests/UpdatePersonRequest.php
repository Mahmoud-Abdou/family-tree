<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'father_name' => ['required', 'string'],
            'grand_father_name' => ['required', 'string'],
            'surname' => ['nullable', 'string'],
            'prefix' => ['nullable', 'string'],
            'job' => ['nullable', 'string'],
            'bio' => ['nullable'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'gender' => ['required', 'in:male,female'],
            'has_family' => ['required', 'in:false,true'],
            'birth_place' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'wife_id' => ['required'],
        ];
    }
}

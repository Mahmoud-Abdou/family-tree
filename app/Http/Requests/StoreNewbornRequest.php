<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewbornRequest extends FormRequest
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
            'title' => ['required'],
            'body' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'first_name' => ['required'],
            'wife_id' => ['required'],
            'gender' => ['required', Rule::in(['male', 'female'])],
        ];
    }
}

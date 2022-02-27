<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarriageRequest extends FormRequest
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
            'husband_id' => ['required', 'exists:persons,id'],
            'wife_id' => ['required'],
            'partner_email' => ['required_if:wife_id,add'],
            'partner_first_name' => ['required_if:wife_id,add'],
            'partner_father_name' => ['required_if:wife_id,add'],
            'partner_mobile' => ['required_if:wife_id,add'],
            'title' => ['required'],
            'body' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d'], // 'date_format:Y-m-d H:i'
        ];
    }
}

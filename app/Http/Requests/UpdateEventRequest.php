<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'city_id' => ['required', 'exists:cities,id'],
            'title' => ['required'],
            'body' => ['required'],
            'image' => ['nullable'],
            'event_date' => ['required', 'date', 'date_format:Y-m-d'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}

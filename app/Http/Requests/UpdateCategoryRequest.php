<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'type' => ['required', 'in:general,media,video,event,news,newborn,marriages'],
            'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'color' => ['nullable']
        ];
    }
}

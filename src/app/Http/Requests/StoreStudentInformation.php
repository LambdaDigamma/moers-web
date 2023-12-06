<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentInformation extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'nickname' => 'required|string|min:3|max:255',
            'birthday' => 'required|date_format:d.m.Y',
            'slogan' => 'required|string|min:3|max:100',
            'motto' => 'required|string|min:3|max:100',
            'strengths' => 'required|string|min:3|max:100',
            'weaknesses' => 'required|string|min:3|max:100',
            'lkA' => 'required|string|min:3|max:100',
            'lkB' => 'required|string|min:3|max:100',
            'highlight' => 'required|string|min:3|max:400',
            'soundtrack' => 'required|string|min:3|max:100',
            'miss_least' => 'required|string|min:3|max:100',
            'miss_most' => 'required|string|min:3|max:100',
            'photo_old' => 'nullable|image',
            'photo_new' => 'nullable|image',
        ];
    }
}

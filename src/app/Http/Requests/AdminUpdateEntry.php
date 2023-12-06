<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateEntry extends FormRequest
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
        // TODO: Add Lat / Lng Validator
        return [
            'lat' => 'sometimes|numeric',
            'lng' => 'sometimes|numeric',
            'name' => 'required|max:255',
            'tags' => 'sometimes|max:1000',
            'street' => 'required|max:255',
            'house_number' => 'required|max:255',
            'postcode' => 'required|digits:5',
            'place' => 'required|max:255',
            'url' => 'sometimes|nullable|url',
            'phone' => 'sometimes|nullable|max:255',
            'monday' => 'sometimes|nullable|max:255',
            'tuesday' => 'sometimes|nullable|max:255',
            'wednesday' => 'sometimes|nullable|max:255',
            'thursday' => 'sometimes|nullable|max:255',
            'friday' => 'sometimes|nullable|max:255',
            'saturday' => 'sometimes|nullable|max:255',
            'sunday' => 'sometimes|nullable|max:255',
            'other' => 'sometimes|nullable|max:255',
        ];
    }
}

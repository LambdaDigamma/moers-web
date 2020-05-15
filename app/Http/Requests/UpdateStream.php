<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStream extends FormRequest
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
            'stream_url' => 'nullable|string|url|min:5',
            'start_date' => 'nullable|date',
            'failure_title' => 'nullable|string',
            'failure_description' => 'nullable|string',
        ];
    }
}

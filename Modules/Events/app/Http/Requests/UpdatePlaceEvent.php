<?php

namespace Modules\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceEvent extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'place_id' => ['nullable', 'exists:places,id'],
        ];
    }
}

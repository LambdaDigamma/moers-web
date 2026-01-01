<?php

namespace Modules\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralEvent extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:300'],
            'description' => ['nullable', 'string', 'min:3', 'max:1000'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}

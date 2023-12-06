<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventPage extends FormRequest
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
        // TODO: Unify this with 'UpdatePage'
        return [
            'blocks' => 'sometimes|array',
            'blocks.*.type' => 'required|in:markdown,image,soundcloud,externalLink',
            'blocks.*.page_id' => 'sometimes|exists:pages,id',
            'blocks.*.order' => 'required|integer|min:0',
        ];
    }
}

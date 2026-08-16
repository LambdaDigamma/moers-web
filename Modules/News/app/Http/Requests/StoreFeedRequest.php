<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFeedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'identifier' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('feeds', 'identifier'),
            ],
            'posts' => ['sometimes', 'array'],
            'posts.*.id' => ['required', 'integer', 'exists:posts,id'],
            'posts.*.order' => ['required', 'integer', 'min:0'],
        ];
    }
}

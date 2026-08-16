<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'posts' => ['sometimes', 'array'],
            'posts.*.id' => ['required', 'integer', 'exists:posts,id'],
            'posts.*.order' => ['required', 'integer', 'min:0'],
        ];
    }
}

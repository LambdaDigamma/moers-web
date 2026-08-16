<?php

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:250'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'external_href' => ['nullable', 'url:http,https', 'max:2048'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'feed_ids' => ['sometimes', 'array'],
            'feed_ids.*' => ['integer', 'exists:feeds,id'],
            'content' => ['nullable', 'array'],
            'header_image' => ['nullable', 'image', 'max:10240'],
            'remove_header_image' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Bitte gib einen Titel fuer den Post an.',
            'external_href.url' => 'Bitte gib eine gueltige URL mit http oder https an.',
            'slug.regex' => 'Der Slug darf nur Kleinbuchstaben, Zahlen und Bindestriche enthalten.',
            'header_image.image' => 'Es koennen nur Bilddateien als Header verwendet werden.',
            'header_image.max' => 'Das Header-Bild darf maximal 10 MB gross sein.',
        ];
    }
}

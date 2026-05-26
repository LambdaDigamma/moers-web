<?php

namespace Modules\Locations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class UpsertLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'street_number' => ['nullable', 'string', 'max:50'],
            'address_addition' => ['nullable', 'string', 'max:255'],
            'postalcode' => ['nullable', 'string', 'max:50'],
            'postal_town' => ['nullable', 'string', 'max:255'],
            'country_code' => ['nullable', 'string', 'size:2'],
            'tags' => ['nullable', 'string', 'max:1000'],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'phone' => ['nullable', 'string', 'max:64', 'regex:/^[0-9+()\\/.\\-\\s]+$/'],
            'return_to_event' => ['nullable', 'integer', 'exists:events,id'],
            'sync_media' => ['sometimes', 'boolean'],
            'media' => ['sometimes', 'array'],
            'media.*' => ['array'],
            'media.*.id' => ['nullable', 'integer'],
            'media.*.file' => ['nullable', 'image', 'max:10240'],
            'media.*.alt' => ['nullable', 'string', 'max:255'],
            'media.*.caption' => ['nullable', 'string', 'max:500'],
            'media.*.credits' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bitte gib einen Namen für den Ort an.',
            'lat.required' => 'Bitte gib einen Breitengrad an.',
            'lat.between' => 'Der Breitengrad muss zwischen -90 und 90 liegen.',
            'lng.required' => 'Bitte gib einen Längengrad an.',
            'lng.between' => 'Der Längengrad muss zwischen -180 und 180 liegen.',
            'url.url' => 'Bitte gib eine gültige Website-URL mit http oder https an.',
            'phone.regex' => 'Bitte gib eine gültige Telefonnummer an.',
            'media.*.file.image' => 'Es können nur Bilddateien hochgeladen werden.',
            'media.*.file.max' => 'Ein Bild darf maximal 10 MB groß sein.',
        ];
    }

    public function after(): array
    {
        return [
            function ($validator): void {
                $mediaItems = $this->input('media', []);

                if (! is_array($mediaItems)) {
                    return;
                }

                foreach ($mediaItems as $index => $mediaItem) {
                    if (! is_array($mediaItem)) {
                        $validator->errors()->add("media.$index", 'Jeder Medieneintrag muss gültige Bilddaten enthalten.');

                        continue;
                    }

                    $hasExistingMedia = filled($mediaItem['id'] ?? null);
                    $hasUploadedFile = $this->hasFile("media.$index.file");

                    if (! $hasExistingMedia && ! $hasUploadedFile) {
                        $validator->errors()->add("media.$index.file", 'Jeder Medieneintrag benötigt ein bestehendes Bild oder einen Upload.');
                    }
                }
            },
        ];
    }
}

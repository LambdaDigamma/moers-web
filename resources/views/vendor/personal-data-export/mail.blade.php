@component('mail::message')
# Persönliche Daten herunterladen

Du kannst nun eine ZIP-Datei mit allen Daten, die wir zu dir haben, herunterladen!

@component('mail::button', ['url' => route('personal-data-exports', $zipFilename)])
ZIP-Datei herunterladen
@endcomponent

Diese Datei wird am {{ $deletionDatetime->format('m.d.Y H:i:s') }} gelöscht.

Danke,
{{ config('app.name') }}
@endcomponent
<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

function vite_assets(): HtmlString
{
    $jsPath = "resources/js/app.js";
    
    $host = config('app.url');
    $tls = Illuminate\Support\Str::lower(Illuminate\Support\Str::before($host, '://')) === 'https';

    if (devServerRunning($tls)) {
        return new HtmlString(<<<HTML
            <script type="module" src="$host:3000/@vite/client"></script>
            <script type="module" src="$host:3000/$jsPath"></script>
        HTML);
    }
    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true, 512, JSON_THROW_ON_ERROR);
    return new HtmlString(<<<HTML
        <script type="module" src="/build/{$manifest[$jsPath]['file']}"></script>
        <link rel="stylesheet" href="/build/{$manifest[$jsPath]['css'][0]}" />
    HTML);
}

function devServerRunning(bool $tls = false): bool
{
    if (app()->environment('local')) {
        try {
            $schema = $tls ? 'https' : 'http';
            Http::withoutVerifying()->get($schema.'://mein-moers.localhost:3000');
            return true;
        } catch (\Exception $e) {
            ray($e);
        }
    }

    return false;
}

function translations($json)
{
    if (!file_exists($json)) {
        return [];
    }
    return json_decode(file_get_contents($json), true);
}

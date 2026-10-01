<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? "system" }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    @inertiaHead

    @if (! ($__inertiaSsrResponse ?? false))
        <title data-inertia>{{ config('app.name', 'Mein Moers') }}</title>
        <meta data-inertia="description" name="description" content="{{ config('app.name', 'Mein Moers') }} bündelt Veranstaltungen, News, Parkplätze, Organisationen und den Abfallkalender für die Stadt Moers.">
        <meta data-inertia="og:title" property="og:title" content="{{ config('app.name', 'Mein Moers') }}">
        <meta data-inertia="og:description" property="og:description" content="{{ config('app.name', 'Mein Moers') }} bündelt Veranstaltungen, News, Parkplätze, Organisationen und den Abfallkalender für die Stadt Moers.">
        <meta data-inertia="og:type" property="og:type" content="website">
        <meta data-inertia="og:site_name" property="og:site_name" content="{{ config('app.name', 'Mein Moers') }}">
        <meta data-inertia="og:url" property="og:url" content="{{ url()->current() }}">
        <meta data-inertia="twitter:card" name="twitter:card" content="summary">
        <meta data-inertia="twitter:title" name="twitter:title" content="{{ config('app.name', 'Mein Moers') }}">
        <meta data-inertia="twitter:description" name="twitter:description" content="{{ config('app.name', 'Mein Moers') }} bündelt Veranstaltungen, News, Parkplätze, Organisationen und den Abfallkalender für die Stadt Moers.">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|inter-tight:500,600,700&display=swap" rel="stylesheet" />

    @routes
    @viteReactRefresh
    @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>

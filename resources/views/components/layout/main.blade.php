<!DOCTYPE html>
<html class="h-full bg-grey-100 scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-itunes-app" content="app-id=1305862555">
    <meta name="twitter:app:name:iphone" content="Mein Moers">
    <meta name="twitter:app:id:iphone" content="1305862555">
    <meta name="twitter:app:name:ipad" content="Mein Moers">
    <meta name="twitter:app:id:ipad" content="1305862555">
    <meta property="al:ios:app_name" content="Mein Moers">
    <meta property="al:ios:app_store_id" content="1305862555">
    <meta property="al:ios:url" content="https://apps.apple.com/de/app/mein-moers/id1305862555">

    {!! SEO::generate(true) !!}

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="/svg/mm.svg" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <link rel="manifest" href="manifest.json" />

    @googlefonts
    @routes

    @vite(['resources/js/app.js', 'resources/css/app.css'])

{{--    {{ vite_assets() }}--}}

    <script defer src="https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js"></script>
    {{-- <script src="https://cdn.apple-mapkit.com/mk/5.x.x/mapkit.js"></script> --}}

    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';
        const el = document.createElement('pwa-update');
        document.body.appendChild(el);
    </script>

    @livewireStyles
</head>

<body class="flex flex-col h-full font-sans antialiased text-gray-900 bg-gray-100">
    <div class="flex-1 grow">
        {{ $slot }}

    </div>
    @if (! $hide)
    <x-footer></x-footer>
    @endif

    @livewireScripts
    @livewire('wire-elements-modal')
    @stack('scripts')

</body>

</html>

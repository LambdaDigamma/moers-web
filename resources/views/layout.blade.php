<!DOCTYPE html>
<html class="h-full bg-grey-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-itunes-app" content="app-id=1305862555">
    <meta name="twitter:app:name:iphone" content="Mein Moers">
    <meta name="twitter:app:id:iphone" content="1305862555">
    <meta name="twitter:app:name:ipad" content="Mein Moers">
    <meta name="twitter:app:id:ipad" content="1305862555">
    <meta property="al:ios:app_name" content="Mein Moers">
    <meta property="al:ios:app_store_id" content="1305862555">
    <meta property="al:ios:url" content="https://apps.apple.com/de/app/mein-moers/id1305862555">

    <title>Mein Moers</title>

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="svg/mm.svg" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    @routes

    <link href="{{ mix('/css/main.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/manifest.js') }}" defer></script>
    <script src="{{ mix('/js/vendor.js') }}" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>

</head>
<body class="font-sans leading-none text-grey-100 bg-white dark:bg-gray-800 antialiased pb-0">

@inertia

</body>
</html>
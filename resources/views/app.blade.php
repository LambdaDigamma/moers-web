<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mein Moers</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        <link rel="icon" type="image/png" href="/favicon.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicon.png" sizes="96x96">
        <link rel="icon" type="image/svg+xml" href="svg/mm.svg" sizes="any">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

        <meta name="apple-itunes-app" content="app-id=1305862555">

        <meta name="twitter:app:name:iphone" content="Mein Moers">
        <meta name="twitter:app:id:iphone" content="1305862555">
        <meta name="twitter:app:name:ipad" content="Mein Moers">
        <meta name="twitter:app:id:ipad" content="1305862555">

        <meta property="al:ios:app_name" content="Mein Moers">
        <meta property="al:ios:app_store_id" content="1305862555">
        <meta property="al:ios:url" content="https://apps.apple.com/de/app/mein-moers/id1305862555">

    </head>
    <body>
        <noscript>
            <strong>We're sorry but Mein Moers doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app" v-cloak></div>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
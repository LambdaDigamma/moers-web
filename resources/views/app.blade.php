<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mein Moers</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <noscript>
            <strong>We're sorry but Mein Moers doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app" v-cloak></div>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
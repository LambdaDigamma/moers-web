<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mein Moers</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
{{--    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">--}}
</head>
<body>

    <noscript>
        <strong>We're sorry but Mein Moers doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app" v-cloak></div>



















{{--    <div id="app" v-cloak>--}}

{{--        <div class="container mb-5">--}}
{{--            <div class="d-flex align-items-center py-4 header">--}}
{{--                <img class="logo" src="svg/mm.svg" />--}}

{{--                <h4 class="mb-0 ml-3">Mein <strong>Moers</strong></h4>--}}

{{--                <router-link tag="button" to="/login" class="btn btn-outline-primary ml-auto mr-3" title="Login">--}}
{{--                    Login--}}
{{--                </router-link>--}}

{{--                <router-link tag="button" to="/register" class="btn btn-outline-primary" title="Register">--}}
{{--                    Register--}}
{{--                </router-link>--}}

{{--            </div>--}}

{{--            <div class="row mt-4">--}}
{{--                <div class="col-2 sidebar">--}}
{{--                    <ul class="nav flex-column">--}}
{{--                        <li class="nav-item">--}}
{{--                            <router-link active-class="active" to="/organisations" class="nav-link d-flex align-items-center pt-0">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                                    <path d="M0 3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm2 2v12h16V5H2zm8 3l4 5H6l4-5z"></path>--}}
{{--                                </svg>--}}
{{--                                <span>Organisationen</span>--}}
{{--                            </router-link>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <router-link active-class="active" to="/events" class="nav-link d-flex align-items-center">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                                    <path d="M7 17H2a2 2 0 0 1-2-2V2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2h-5l4 2v1H3v-1l4-2zM2 2v11h16V2H2z"></path>--}}
{{--                                </svg>--}}
{{--                                <span>Veranstaltungen</span>--}}
{{--                            </router-link>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--                <div class="col-10">--}}
{{--                    <router-view></router-view>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <script src="{{ mix('js/main.js') }}"></script>--}}
</body>
</html>
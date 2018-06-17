<!DOCTYPE html>
<html>
<head>

    @include('partials._head')
    @yield('style')

    <style>



    </style>

</head>

<body>

@include('partials._nav')

@include('partials._messages')

@yield('content')

@include('partials._js')

</body>
</html>
<!DOCTYPE html>
<html>
<head>

    @include('legacyPartials._head')
    @yield('style')

</head>

<body>

    @include('legacyPartials._nav')

    @include('legacyPartials._messages')

    @yield('content')

    @include('legacyPartials._footer')

    @include('legacyPartials._js')

</body>
</html>
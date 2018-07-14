<!DOCTYPE html>
<html>
<head>

    @include('admin._head')
    @yield('style')

    <style>



    </style>

</head>

<body class="">

    <div class="wrapper ">

        @include('admin._sidebar')

        <div class="main-panel">

            @include('admin._nav')

            <div class="content">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            @include('vendor.entrust-gui.partials.notifications')
                        </div>
                    </div>

                </div>

                @yield('content')

            </div>

        </div>


    </div>

    @include('admin._scripts')

</body>
</html>
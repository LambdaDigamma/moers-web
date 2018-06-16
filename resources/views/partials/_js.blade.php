<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script src="../js/snowstorm-min.js"></script>

<script>

    $(document).ready(function() {
        $(".button-collapse").sideNav();
        snowStorm.freezeOnBlur = true;
        snowStorm.stop();
    });

</script>

@yield('scripts')
@extends('legacy.main')

@section('content')

    <div id="hero" class="container-fluid">
        <div class="container">
            <img class="responsive-img" style="" src="{{ URL::asset('/img/hero.png') }}">
            <h3 class="white-text center" style="margin: 0; padding: 0;">MOERS IN DEINER HOSENTASCHE</h3>
            <h6 class="center white-text" style="font-size: 1.25em; margin-top: 20px;">
                Suche Moerser Geschäfte & Parkplätze mit Live-Daten und bewege Dich mit interaktiven 360° Panoramen durch die Stadt!
            </h6>
            <div class="center">
                <a id="appstore" href="https://itunes.apple.com/de/app/mein-moers/id1305862555?mt=8" class="center" style="margin-top: 20px; margin-left: 20px;"></a>
            </div>
        </div>
    </div>

    <div id="details" class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m4">
                    <div class="center promo">
                        <i class="material-icons">shopping_cart</i>
                        <p class="promo-caption">Geschäfte: Die wichtigsten Daten</p>
                        <p class="light center">
                            Habe die Öffnungszeiten, Adressen & Telefon-Nummern der Moerser Geschäfte immer in der Hosentasche!
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo">
                        <i class="material-icons">3d_rotation</i>
                        <p class="promo-caption">360° Panoramen</p>
                        <p class="light center">
                            Bewege Dich mit interaktiven 360° Panoramen bequem von der Couch aus durch die Moerser Innenstadt und besuche Geschäfte von innen!
                        </p>
                    </div>
                </div>
                <div class="col s12 m4">
                    <div class="center promo">
                        <i class="material-icons">trending_up</i>
                        <p class="promo-caption">Parkplätze: Live-Daten</p>
                        <p class="light center">
                            In der App findest Du Live-Daten der Parkplätze in der Innenstadt.
                            Die Daten werden über das Parkleitsystem von der Stadt zur Verfügung gestellt.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div id="media" class="container-fluid" style="height: 600px;">--}}
        {{--<div class="container">--}}
            {{--<div class="section">--}}
                {{--<div class="row">--}}
                    {{--<div class="col s12">--}}
                        {{--<video class="responsive-video center" controls>--}}
                            {{--<source src="{!! URL::asset('video/MeinMoers.mp4') !!}" type="video/mp4">--}}
                            {{--Your browser does not support the video tag.--}}
                        {{--</video>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div id="feedback" class="container-fluid" style="height: 400px;">--}}
        {{--<div class="container">--}}
            {{--<div class="section">--}}
                {{--<div class="row">--}}
                    {{--<div class="col s12">--}}
                        {{--<h4 class="center">Das sagen Benutzer:</h4>--}}
                        {{--<div class="carousel">--}}
                            {{--<div class="col s8 carousel-item card-panel center">--}}
                                {{--<p class="center">--}}
                                    {{--<b>"Modernipsum dolor sit amet baroque eclecticism aestheticism neo-expressionism sound art cobra, sound art fauvism op art socialist realism modern art kinetic art formalism land art."</b>--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div id="business" class="container-fluid">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12">
                        <h4 class="center white-text">Für Geschäftsbetreiber</h4>
                        <div class="row">
                            <div class="col s12 m6 offset-m3">
                                <p class="white-text center">In Kürze können Sie Ihr Unternehmen auch zur App hinzufügen!</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m2 offset-m5">
                                <div class="card-panel orange darken-4">
                                    <span class="white-text">
                                        <center>BALD VERFÜGBAR!</center>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="android" class="container">
        <div class="row">
            <div class="col s12">
                <h4 class="center">MEIN MOERS FÜR ANDROID</h4>
                <div class="row">
                    <form class="col s12" method="POST" action="{{ route('mailinglist.subscribe') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="input-field col s12 l5 offset-l3">
                                <input id="email" type="email" name="email" class="validate">
                                <label for="email" data-error="wrong" data-success="right">Email</label>
                            </div>
                            <div class="input-field col s12 l1">
                                <button class="waves-effect waves-light btn btn-large orange darken-4" type="submit">Eintragen</button>
                            </div>
                        </div>
                    </form>
                    <p class="light center">
                        <b>Mein Moers</b> wird es bald auch für Android geben! Trag Dich in die Mailingliste ein und wir halten Dich auf dem Laufenden.
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        $(document).ready(function(){
            $('.carousel').carousel();
        });

    </script>

@endsection

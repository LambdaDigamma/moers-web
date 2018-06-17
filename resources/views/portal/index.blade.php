@extends('plain')

@section('title', 'Portal')

@section('style')

    <style>

        #mapid {
            height: 93.5vh;
        }

        .zero-spacing {
            margin: 0;
            padding: 0;
        }

    </style>

@endsection

@section('content')

    <div class="container-fluid zero-spacing">

        <div class="row zero-spacing">

            <div class="zero-spacing col s3" style="height: 93.5vh; margin: 0; padding: 0; overflow: scroll">

                <ul class="collection zero-spacing">

                    @foreach($shops as $shop)

                        <li class="collection-item avatar">
                            <i class="material-icons circle yellow grey-text text-darken-3">shopping_cart</i>
                            <span class="title"><strong>{{ $shop->name }}</strong></span>
                            <p class="gray-text">{{ $shop->branch }}<br>
                                {{ $shop->street }} {{ $shop->house_number }}
                            </p>
                            <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                        </li>

                    @endforeach

                </ul>

            </div>

            <div class="col s9" style="margin: 0; padding: 0;">
                <div id="mapid"></div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

        let map = L.map('mapid').setView([51.451667, 6.626389], 13);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 20,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGFtYmRhZGlnYW1tYSIsImEiOiJjamloZTRjN3gxNTg1M2t1cGVndWs0OWJ6In0.U90EUX3TVo7VBlrLRGgGrg'
        }).addTo(map);

        @forEach($shops as $shop)

            L.marker([{{ $shop->lat }}, {{ $shop->lng }}])
            .bindPopup("<b>{{ $shop->name }}</b><br>")
            .addTo(map);

        @endforeach

    </script>

@endsection

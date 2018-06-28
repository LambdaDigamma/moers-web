@extends('plain')

@section('title', 'Geschäft hinzufügen')

@section('style')

    <style>
        .marginTop {

            margin-top: 4vh;

        }
        .divider-heading {
            font-size: 1.25em;
        }
        .row-margin {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    </style>

@endsection

@section('content')

    <div class="container marginTop">

        <div class="row">

            {!! Form::open(array('route' => 'shops.store', 'method' => 'POST', 'class' => 'col s12 z-depth-2 form-padding')) !!}

            <div class="row">
                <h5 class="center" style="margin-top: 2vh; margin-bottom: 2vh;"><b>Neues Geschäft hinzufügen</b></h5>
            </div>

            <div class="row row-margin">
                <div class="col s12">
                    <strong class="divider-heading">Allgemeine Informationen:</strong><br>
                </div>
            </div>

            {{-- General --}}

            <div class="row row-margin">
                <div class="input-field col s12">
                    <input id="name" type="text" class="validate">
                    <label for="name">Name</label>
                </div>
                <div class="input-field col s12">
                    <input id="branch" type="text" class="validate">
                    <label for="branch">Branche</label>
                </div>
            </div>

            <div class="row row-margin">
                <div class="col s12">
                    <strong class="divider-heading">Adresse:</strong><br>
                </div>
            </div>

            {{-- Adress --}}

            <div class="row row-margin">
                <div class="input-field col s8">

                    <input id="street" type="text" class="validate">
                    <label for="street">Straße</label>

                </div>
                <div class="input-field col s4">

                    <input id="houseNumber" type="text" class="validate">
                    <label for="houseNumber">Nr</label>

                </div>
                <div class="input-field col s6">

                    <input id="postcode" type="text" class="validate">
                    <label for="postcode">Postleitzahl</label>

                </div>
                <div class="input-field col s6">

                    <input id="place" type="text" class="validate">
                    <label for="place">Ort</label>

                </div>
            </div>

            {{--  --}}

            <div class="row row-margin">
                <div class="col s12">
                    <strong class="divider-heading">Kontakt:</strong>
                </div>
            </div>

            <div class="row row-margin">
                <div class="input-field col s6">
                    <input id="web" type="text" class="validate">
                    <label for="web">Webseite</label>
                </div>
                <div class="input-field col s6">
                    <input id="phone" type="tel" class="validate">
                    <label for="phone">Telefon</label>
                </div>
            </div>

            {{-- Opening Hours --}}

            <div class="row row-margin">
                <div class="col s12">
                    <strong class="divider-heading">Öffnungszeiten:</strong><br>
                    <i>Bsp.: 08:00-12:00, 14:00-20:00</i>
                </div>
            </div>
            <div class="row row-margin">
                <div class="input-field col s6">

                    <input id="mo-start" type="text" class="validate">
                    <label for="mo-start">Montag</label>

                </div>
                <div class="input-field col s6">

                    <input id="tuesday" type="text" class="validate">
                    <label for="tuesday">Dienstag</label>

                </div>
                <div class="input-field col s6">

                    <input id="wednesday" type="text" class="validate">
                    <label for="wednesday">Mittwoch</label>

                </div>
                <div class="input-field col s6">

                    <input id="thursday" type="text" class="validate">
                    <label for="thursday">Donnerstag</label>

                </div>
                <div class="input-field col s6">

                    <input id="friday" type="text" class="validate">
                    <label for="friday">Freitag</label>

                </div>
                <div class="input-field col s6">

                    <input id="saturday" type="text" class="validate">
                    <label for="saturday">Samstag</label>

                </div>
                <div class="input-field col s6">

                    <input id="sunday" type="text" class="validate">
                    <label for="sunday">Sonntag</label>

                </div>
                <div class="input-field col s6">

                    <input id="other" type="text" class="validate">
                    <label for="other">Sonstiges</label>

                </div>
            </div>

            <div class="row row-margin">
                <div class="col s12">
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Senden
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>


            {!! Form::close() !!}

        </div>

    </div>

@endsection
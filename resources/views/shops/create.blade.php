@extends('plain')

@section('title', 'Geschäft hinzufügen')

@section('style')

    <style>
        .marginTop {

            margin-top: 4vh;

        }
    </style>

@endsection

@section('content')

    <div class="container marginTop">

        <div class="row">

            <div class="col s12 z-depth-2">

                <h5 class="center" style="margin-top: 2vh; margin-bottom: 2vh;"><b>Neues Geschäft hinzufügen</b></h5>

                {!! Form::open(array('route' => 'shops.store', 'method' => 'POST')) !!}

                <div class="input-field col s12">

                    <input placeholder="Name" id="name" type="text" class="validate">
                    <label for="name">Name</label>

                </div>
                <div class="input-field col s8">

                    <input placeholder="Name" id="name" type="text" class="validate">
                    <label for="name">Name</label>

                </div>
                <div class="input-field col s4">

                    <input placeholder="Nr" id="houseNumber" type="text" class="validate">
                    <label for="houseNumber">Nr</label>

                </div>

            </div>

        </div>

    </div>

@endsection
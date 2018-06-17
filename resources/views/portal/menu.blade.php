@extends('plain')

@section('title', 'Portal')

@section('style')

@endsection

@section('content')

    <div class="container" style="margin-top: 5vh;">

        <div class="row">

            <div class="col s12 l4">

                <div class="card">
                    <div class="card-content">
                        <span class="card-title"><b>Geschäfte</b></span>
                        <p>Alle Moerser Geschäfte</p>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('portal.index') }}" class="waves-effect waves-dark btn yellow black-text">Ansehen</a>
                        <a href="{{ route('shops.create') }}" class="waves-effect waves-dark btn orange">Hinzufügen</a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

    </script>

@endsection

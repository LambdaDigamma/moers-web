@extends('locations::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('locations.name') !!}</p>
@endsection

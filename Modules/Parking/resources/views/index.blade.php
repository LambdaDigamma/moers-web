@extends('parking::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('parking.name') !!}</p>
@endsection

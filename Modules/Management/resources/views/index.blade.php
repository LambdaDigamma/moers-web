@extends('management::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('management.name') !!}</p>
@endsection

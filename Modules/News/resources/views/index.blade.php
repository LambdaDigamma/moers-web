@extends('news::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('news.name') !!}</p>
@endsection

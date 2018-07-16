@extends('admin.template')

@section('content')

    <div class="card">
        <div class="card-header card-header-warning">
            <h4 class="card-title">Create Shop</h4>
            <p class="card-category"></p>
        </div>
        <div class="card-body">

            <form action="{{ route('shops.store') }}" method="post" role="form">
                @include('admin.shops.partials.form')
                <button type="submit" class="btn btn-primary pull-right">{{ trans('entrust-gui::button.create') }}</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>

@endsection

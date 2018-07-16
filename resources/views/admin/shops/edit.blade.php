@extends('admin.template')

@section('content')

    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Edit Shop</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('shops.update', $shop->id) }}" method="post" role="form">
                <input type="hidden" name="_method" value="put">
                @include('admin.shops.partials.form')
                @if(!$shop->validated)
                <button type="button" class="btn btn-success pull-left" onclick="event.preventDefault(); document.getElementById('approve-form').submit();">Approve</button>
                @else
                <button type="button" class="btn btn-success pull-left" onclick="event.preventDefault(); document.getElementById('reject-form').submit();">Reject</button>
                @endif
                <button type="submit" id="save" class="btn btn-primary pull-right">{{ trans('entrust-gui::button.save') }}</button>
            </form>

            <form id="approve-form" action="{{ route('shops.approve', $shop->id) }}" method="POST" style="display: none;">
                @csrf
            </form>

            <form id="reject-form" action="{{ route('shops.reject', $shop->id) }}" method="POST" style="display: none;">
                @csrf
            </form>

        </div>
    </div>

@endsection


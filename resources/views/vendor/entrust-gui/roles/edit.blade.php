@extends('admin.template')

@section('content')

    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Edit Role</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('entrust-gui::roles.update', $model->id) }}" method="post" role="form">
                <input type="hidden" name="_method" value="put">
                @include('entrust-gui::roles.partials.form')
                <button type="submit" id="save" class="btn btn-primary pull-right">{{ trans('entrust-gui::button.save') }}</button>
            </form>
        </div>
    </div>

@endsection

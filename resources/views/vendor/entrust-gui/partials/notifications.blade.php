@if (isset($errors) && count($errors->all()) > 0)

<div class="alert alert-danger" role="alert">
    <h4><b>Error</b></h4>
    <ul>
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
    </ul>
</div>

@endif
@if ($message = Session::get('success'))

    <div class="alert alert-success" role="alert">
        <strong>{{ trans('entrust-gui::flash.success') }}</strong> {{ $message }}
    </div>
    {{ Session::forget('success') }}

@endif

@if ($message = Session::get('error'))

    <div class="alert alert-danger" role="alert">
        <strong>{{ trans('entrust-gui::flash.error') }}</strong> {{ $message }}
    </div>
    {{ Session::forget('error') }}

@endif

@if ($message = Session::get('warning'))

    <div class="alert alert-warning" role="alert">
        <strong>{{ trans('entrust-gui::flash.warning') }}</strong> {{ $message }}
    </div>
    {{ Session::forget('warning') }}

@endif

@if ($message = Session::get('info'))

    <div class="alert alert-info" role="alert">
        <strong>{{ trans('entrust-gui::flash.info') }}</strong> {{ $message }}
    </div>
    {{ Session::forget('info') }}

@endif

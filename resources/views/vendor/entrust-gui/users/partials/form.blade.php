<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group">
    <label class="bmd-label-floating" for="name">Name</label>
    <input type="name" class="form-control" id="name" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $user->name }}">
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label class="bmd-label-floating" for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ (Session::has('errors')) ? old('email', '') : $user->email }}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <label class="bmd-label-floating" for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
    @if(Route::currentRouteName() == 'entrust-gui::users.edit')
        <div class="alert alert-info mt-2" role="alert">
            Leave the password field blank if you wish to keep it the same.
        </div>
    @endif
</div>

@if(Config::get('entrust-gui.confirmable') === true)
<div class="form-group">
    <label class="bmd-label-floating" for="password">Confirm Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
</div>
@endif

<div class="form-group">
    <label for="roles">Roles</label>
    <select name="roles[]" id="roles" multiple class="form-control">
        @foreach($roles as $index => $role)
            <option value="{{ $index }}" {{ ((in_array($index, old('roles', []))) || ( ! Session::has('errors') && $user->roles->contains('id', $index))) ? 'selected' : '' }}>{{ $role }}</option>
        @endforeach
    </select>
</div>

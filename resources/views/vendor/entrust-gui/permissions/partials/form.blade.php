<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label class="bmd-label-floating" for="name">Name</label>
    <input type="input" class="form-control" id="name" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $model->name }}">
</div>
<div class="form-group">
    <label class="bmd-label-floating" for="display_name">Display name</label>
    <input type="input" class="form-control" id="display_name" name="display_name" value="{{ (Session::has('errors')) ? old('display_name', '') : $model->display_name }}">
</div>
<div class="form-group">
    <label class="bmd-label-floating" for="description">Description</label>
    <input type="input" class="form-control" id="description" name="description" value="{{ (Session::has('errors')) ? old('description', '') : $model->description }}">
</div>
<div class="form-group">
    <label class="bmd-label-floating" for="roles">Roles</label>
    <select name="roles[]" multiple class="form-control">
        @foreach($relations as $index => $relation)
            <option value="{{ $index }}" {{ ((in_array($index, old('roles', []))) || (!Session::has('errors') && $model->roles->contains('id', $index))) ? 'selected' : '' }}>{{ $relation }}</option>
        @endforeach
    </select>
</div>
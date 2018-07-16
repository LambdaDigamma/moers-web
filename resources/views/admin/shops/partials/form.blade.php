<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label class="bmd-label-floating" for="name">Name</label>
    <input type="input" class="form-control" id="name" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $shop->name }}">
</div>

<div class="form-group">
    <label class="bmd-label-floating" for="branch">Branch</label>
    <input type="input" class="form-control" id="branch" name="branch" value="{{ (Session::has('errors')) ? old('branch', '') : $shop->branch }}">

</div>

<div class="form-row">

    <div class="form-group col-md-8">
        <label class="bmd-label-floating" for="branch">Street</label>
        <input type="input" class="form-control" id="street" name="street" value="{{ (Session::has('errors')) ? old('street', '') : $shop->street }}">
    </div>

    <div class="form-group col-md-4">
        <label class="bmd-label-floating" for="branch">House Number</label>
        <input type="input" class="form-control" id="house_number" name="house_number" value="{{ (Session::has('errors')) ? old('house_number', '') : $shop->house_number }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="postcode">Postcode</label>
        <input type="input" class="form-control" id="postcode" name="postcode" value="{{ (Session::has('errors')) ? old('postcode', '') : $shop->postcode }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Place</label>
        <input type="input" class="form-control" id="place" name="place" value="{{ (Session::has('errors')) ? old('place', '') : $shop->place }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="url">Website</label>
        <input type="input" class="form-control" id="url" name="url" value="{{ (Session::has('errors')) ? old('url', '') : $shop->url }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Phone</label>
        <input type="input" class="form-control" id="phone" name="phone" value="{{ (Session::has('errors')) ? old('phone', '') : $shop->phone }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="postcode">Monday</label>
        <input type="input" class="form-control" id="monday" name="monday" value="{{ (Session::has('errors')) ? old('monday', '') : $shop->monday }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Tuesday</label>
        <input type="input" class="form-control" id="tuesday" name="tuesday" value="{{ (Session::has('errors')) ? old('tuesday', '') : $shop->tuesday }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="postcode">Wednesday</label>
        <input type="input" class="form-control" id="wednesday" name="wednesday" value="{{ (Session::has('errors')) ? old('wednesday', '') : $shop->wednesday }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Thursday</label>
        <input type="input" class="form-control" id="thursday" name="thursday" value="{{ (Session::has('errors')) ? old('tuesday', '') : $shop->thursday }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="postcode">Friday</label>
        <input type="input" class="form-control" id="friday" name="friday" value="{{ (Session::has('errors')) ? old('friday', '') : $shop->friday }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Saturday</label>
        <input type="input" class="form-control" id="saturday" name="saturday" value="{{ (Session::has('errors')) ? old('saturday', '') : $shop->saturday }}">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="postcode">Sunday</label>
        <input type="input" class="form-control" id="sunday" name="sunday" value="{{ (Session::has('errors')) ? old('sunday', '') : $shop->sunday }}">
    </div>

    <div class="form-group col-md-6">
        <label class="bmd-label-floating" for="place">Other</label>
        <input type="input" class="form-control" id="other" name="other" value="{{ (Session::has('errors')) ? old('other', '') : $shop->other }}">
    </div>

</div>
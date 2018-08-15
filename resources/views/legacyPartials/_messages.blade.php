@if (Session::has('success'))

    <div class="row marginTop">
        <div class="col s12 m12">
            <div class="card green darken-1">
                <div class="row">
                    <div class="col s12 m10">
                        <div class="card-content white-text">
                            <strong>Success: </strong>{{ Session::get('success') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

@if (count($errors) > 0)

    <div class="row">
        <div class="col s12 m12">
            <div class="card red darken-1">
                <div class="row">
                    <div class="col s12 m10">
                        <div class="card-content white-text">
                            <strong>Errors: </strong><ul>

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
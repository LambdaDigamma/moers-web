@extends('admin.template')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_circle</i>
                        </div>
                        <p class="card-category">User</p>
                        <h3 class="card-title">{{ count($users) }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">insert_link</i>
                            <a href="{{ route('entrust-gui::users.index') }}">See all</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">shopping_cart</i>
                        </div>
                        <p class="card-category">Shops</p>
                        <h3 class="card-title">{{ count($shops) }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">insert_link</i>
                            <a href="{{ route('admin') }}">See all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
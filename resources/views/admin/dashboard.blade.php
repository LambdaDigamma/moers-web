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
                            <a href="{{ route('shops.index') }}">See all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">New Shops</h4>
                        <p class="card-category">New crowd-sourced Shops</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <th>Name</th>
                            <th>Creator</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach($unvalidatedShops as $i => $shop)
                                <tr>
                                    <td>{{ $shop->name }}</td>
                                    <td>{!! $shop->creator()->name !!}</td>
                                    <td class="td-actions">
                                        <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-info">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title">Top Users</h4>
                        <p class="card-category">All-time best users</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-danger">
                            <th>Position</th>
                            <th>Name</th>
                            <th>Points</th>
                            </thead>
                            <tbody>
                            @foreach($bestUsers as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->points }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
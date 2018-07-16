@extends('admin.template')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Shops</h4>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-success" href="{{ route('shops.create') }}">Create Shop</a>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach($shops as $shop)
                                    <tr>
                                        <td>{{ $shop->id }}</td>
                                        <td>{{ $shop->name }}</td>
                                        <td>{{ $shop->street }} {{ $shop->house_number }}</td>
                                        <td class="td-actions">
                                            <form style="display: inline;" action="{{ route('shops.destroy', $shop->id) }}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="button" onclick="window.location.href='{{ route('shops.edit', $shop->id) }}'" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Edit Task" class="btn btn-primary btn-link btn-sm" >
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="submit" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {!! $shops->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@extends('admin.template')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Roles</h4>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-success" href="{{ route('entrust-gui::roles.create') }}">{{ trans('entrust-gui::button.create-role') }}</a>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->name }}</td>
                                        <td class="td-actions">

                                            <form style="display: inline;" action="{{ route('entrust-gui::roles.destroy', $model->id) }}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="button" onclick="window.location.href='{{ route('entrust-gui::roles.edit', $model->id) }}'" data-toggle="tooltip" rel="tooltip" data-placement="top" title="Edit Task" class="btn btn-primary btn-link btn-sm" >
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
                                {!! $models->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
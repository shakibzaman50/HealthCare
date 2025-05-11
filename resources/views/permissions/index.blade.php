@extends('layouts/layoutMaster')

@section('title', 'Show Permission')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions</h3>
                    <div class="card-tools">
                        <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Permission</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('permissions.show', $permission->id) }}">Show</a>
                                <a class="btn btn-primary"
                                    href="{{ route('permissions.edit', $permission->id) }}">Edit</a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div>
                        {{ $permissions->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
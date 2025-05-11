@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Role Management</h2>
            
            @can('role-create')
            <a class="btn btn-success" href="{{ route('roles.create') }}">Create New Role</a>
            @endcan
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <label>{{ $message }}</label>
</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="User Actions">
                        <a class="btn btn-primary flex-fill" href="{{ route('roles.show', $role->id) }}">Show</a>
                        @can('role-edit')
                        <a class="btn btn-success flex-fill" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                        @endcan
                        @can('role-delete')
                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger flex-fill">Delete</button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{!! $roles->render() !!}
@endsection
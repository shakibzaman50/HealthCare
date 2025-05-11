@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Show Role</h2>
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <p>{{ $role->name }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="permissions" class="form-label"><strong>Permissions:</strong></label>
            <div>
                @if (!empty($rolePermissions))
                @foreach ($rolePermissions as $v)
                <span class="badge bg-success">{{ $v->name }}</span>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Show User</h2>
            <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Name:</strong></label>
            <p>{{ $user->name }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label"><strong>Email:</strong></label>
            <p>{{ $user->email }}</p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label for="roles" class="form-label"><strong>Roles:</strong></label>
            <div>
                @if (!empty($user->getRoleNames()))
                @foreach ($user->getRoleNames() as $v)
                <span class="badge bg-success">{{ $v }}</span>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
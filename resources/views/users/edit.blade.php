@extends('layouts/layoutMaster')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit User</h2>
            <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Something went wrong.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" value="{{ $user->name }}" id="name" placeholder="Name"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email:</strong></label>
                <input type="text" name="email" value="{{ $user->email }}" id="email" placeholder="Email"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Phone:</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password" class="form-label"><strong>Password:</strong></label>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="confirm-password" class="form-label"><strong>Confirm Password:</strong></label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="type" class="form-label">Type:</label>
                <select name="type" class="form-select form-control">
                    <option value="1" @if(1==$user->type) selected @endif>Super Admin</option>
                    <option value="2" @if(2==$user->type) selected @endif>Admin</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="roles" class="form-label"><strong>Role:</strong></label>
                <select name="roles[]" class="form-select form-control">

                    @foreach($roles as $key => $value)
                    <option value="{{ $key }}" @if(in_array($key, $userRole)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="roles" class="form-label"><strong>Status:</strong></label>
                <select name="status" class="form-select form-control">
                    @foreach($status as $key => $value)
                    <option value="{{ $value }}" @if($value==$user->status) selected @endif>{{ $key }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
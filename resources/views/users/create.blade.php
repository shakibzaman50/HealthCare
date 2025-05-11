@extends('layouts/layoutMaster')

@section('title', 'Create User')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Create New User</h4>
            <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong>Something went wrong.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card p-2">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Phone:</label>
                    <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control"
                        autocomplete="new-password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password:</label>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password"
                        class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select name="type" class="form-select form-control">
                        <option value="1">Super Admin</option>
                        <option value="2">Admin</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="roles" class="form-label">Role:</label>
                    <select name="roles[]" class="form-select form-control">
                        @foreach($roles as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>



@endsection
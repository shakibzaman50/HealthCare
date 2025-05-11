@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Create New Role</h2>
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> Something went wrong.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('roles.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" placeholder="Name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="permission" class="form-label"><strong>Permissions:</strong></label>
                <div class="list-group">
                    @foreach ($permission as $value)
                    <label class="list-group-item d-flex align-items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                            class="form-check-input me-3" id="permission{{ $value->id }}">
                        {{ $value->name }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

@endsection
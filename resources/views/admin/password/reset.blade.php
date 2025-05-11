@extends('layouts/layoutMaster')

@section('title', 'Reset Password')

@section('content_header')
<h1>Reset Password</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="box box-primary">
            <form action="{{ route('update.password') }}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation">
                    </div>
                </div>
                <p>Password patern will be:</p>
                <ul>
                    <li>Minimum length of 8 characters</li>
                    <li>At least one lowercase letter</li>
                    <li>At least one uppercase letter</li>
                    <li>At least one digit</li>
                    <li>At least one special character</li>
                </ul>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
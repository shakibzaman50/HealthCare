@extends('backend.app.user.app')
@section('title', 'user details')
@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{ $user->name }}'s details</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Name</label>
                <div class="col-6 col-md-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Role</label>
                <div class="col-6 col-md-8">
                    <span class="badge badge-info">{{ $user->role==3?'Super Admin':($user->role==2?'Admin':($user->role==1?'User':'Guest')) }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Email</label>
                <div class="col-6 col-md-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Gender</label>
                <div class="col-6 col-md-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->gender }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Status</label>
                <div class="col-6 col-md-8">
                    {!! $user->status_badge !!}
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-6 col-md-4 fw-semibold text-muted">Is Deleted</label>
                <div class="col-6 col-md-8">
                    {!! $user->delete_badge !!}
                </div>
            </div>
        </div>
    </div>
@endsection

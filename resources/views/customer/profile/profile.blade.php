@extends('layouts/layoutMaster')

@section('title', 'Profile')

@section('content_header')
<h1>Profile Information</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card box-primary">
            <div class="card-header with-border">
                <h3 class="box-title">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <p>Lifetime package: {{ $user->lifetimePackage?->name }}</p>
                <p>Monthly package: {{ $user->monthlyPackage?->name }}</p>
                <p>Monthly package status: {{ $user->monthly_package_status }}</p>
                <p>Monthly package enroll date: {{ $user->monthly_package_enrolled_at }}</p>
                <p>Balance: {{ $user->balance }}</p>
            </div>
        </div>
    </div>
</div>
@stop

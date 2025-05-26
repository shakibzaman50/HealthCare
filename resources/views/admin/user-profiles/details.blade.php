@extends('layouts/layoutMaster')

@section('title', 'Profile Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Details</h4>
                <div class="d-flex gap-1">
                    <a href="{{ route('user-profiles.show', $user) }}" class="btn btn-secondary btn-sm">
                        Back to Profiles
                    </a>
                    <a href="{{ route('user-profiles.index') }}" class="btn btn-secondary btn-sm">
                        Back to Users
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img src="{{ $profile->avatar_url }}" alt="Profile Avatar" class="rounded-circle img-fluid"
                            style="max-width: 200px;">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $profile->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Age:</th>
                                        <td>{{ $profile->age }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender:</th>
                                        <td>{{ $profile->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Birth Year:</th>
                                        <td>{{ $profile->birth_year }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Physical Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>Weight:</th>
                                        <td>{{ $profile->weight }} {{ $profile->weightUnit->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Height:</th>
                                        <td>{{ $profile->height }} {{ $profile->heightUnit->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>BMI:</th>
                                        <td>{{ $profile->bmi }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
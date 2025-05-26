@extends('layouts/layoutMaster')

@section('title', 'User Profiles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profiles for {{ $user->name }}</h4>
                <a href="{{ route('user-profiles.index') }}" class="btn btn-secondary btn-sm">
                    Back to Users
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>BMI</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profiles as $profile)
                            <tr>
                                <td>{{ $profile->name }}</td>
                                <td>{{ $profile->age }}</td>
                                <td>{{ $profile->gender }}</td>
                                <td>{{ $profile->weight }} {{ $profile->weightUnit->name ?? '' }}</td>
                                <td>{{ $profile->height }} {{ $profile->heightUnit->name ?? '' }}</td>
                                <td>{{ $profile->bmi }}</td>
                                <td>
                                    <a href="{{ route('user-profiles.details', ['user' => $user, 'profile' => $profile]) }}" 
                                       class="btn btn-info btn-sm">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
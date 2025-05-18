@extends('backend.app.user.app')
@section('title', 'user bp records')
@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{ $user->name }}'s all bp records</h3>
            </div>
        </div>
        @include('backend.includes.bp.table')
    </div>
@endsection
@section('js')
    @include('backend.includes.bp.js')
@endsection

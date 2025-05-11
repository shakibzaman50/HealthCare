@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

{{-- @section('content_header')
<h1>Dashboard</h1>
@endsection --}}

@section('content')


<div class="row">
    <div class="col-sm-6">
        <div class="card  m-5">
            <div class="card-body">
                <h5 class="card-title">Welcome</h5>
                <h2 class="card-text text-success">{{ auth()->user()->name }}</h2>

                <div class="card box-primary">
                    <div class="card-header with-border">
                        <h3 class="box-title">Overview</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Lifetime Package</th>
                                    <td>{{ $user->lifetimePackage?->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Monthly Package</th>
                                    <td>{{ $user->monthlyPackage?->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Monthly Package Status</th>
                                    <td>{{ $user->monthly_package_status ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Monthly Package Enroll Date</th>
                                    <td>{{ $user->monthly_package_enrolled_at ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <td>{{ $user->balance ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <form id="user-logout-form" method="POST" action="{{ route('user.logout') }}">
                    @csrf
                </form>
                <button class="btn btn-danger" type="button"
                    onclick="document.getElementById('user-logout-form').submit();">Logout</button>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card m-5">
            <div class="card-body">
                <h5 class="card-title">{{ __('adminlte::adminlte.your_referral_link') }} - </h5>
                @if(auth()->guard('customer')->user()->lifetime_package != null)
                <p class="card-text text-success"> {{$referral}} </p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container my-5">

    <h1 class="text-center pricing-table-title">Take Your Earnings To The Next Level</h1>
    <h5 class="text-center pricing-table-subtitle mb-5">Enroll within 72 hrs to get discount.</h5>
    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-4">
            <div class="card pricing-card @if($package->id == 2) pricing-card-highlighted @endif pricing-plan-pro">
                <div class="card-body">
                    <i class="fas fa-coffee pricing-plan-icon"></i>
                    <p class="pricing-plan-title">{{ $package->name }}</p>
                    <h3 class="pricing-plan-cost ml-auto">{{ $package->price }}</h3>
                    <ul class="pricing-plan-features">
                        <li>Package details</li>
                    </ul>
                    <form id="package-form" method="POST" action="{{ route('customer.enroll.lifetime') }}">
                        @csrf
                        <input type="hidden" name="package" value="{{ $package->id }}">
                        <button type="submit" class="pricing-plan-purchase-btn btn-sub btn-success p-2 rounded">Choose
                            Plan</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@if(auth()->guard('customer')->user()->lifetime_package != null)
<div class="container my-5">

    <h1 class="text-center pricing-table-title">Monthly packages</h1>
    <div class="row">
        @foreach($monthlyPackages as $package)
        <div class="col-md-4">
            <div class="card pricing-card pricing-plan-pro">
                <div class="card-body">
                    <i class="fas fa-coffee pricing-plan-icon"></i>
                    <p class="pricing-plan-title">{{ $package->name }}</p>
                    <h3 class="pricing-plan-cost ml-auto">{{ $package->price }}</h3>
                    <ul class="pricing-plan-features">
                        <li>Package details</li>
                    </ul>
                    <form class="package-form" id="package-form" method="POST"
                        action="{{ route('customer.enroll.monthly') }}">
                        @csrf
                        <input type="hidden" name="package" value="{{ $package->id }}">
                        <button type="submit" class="btn pricing-plan-purchase-btn btn-sub">Choose Plan</button>
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to choose this plan?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmButton">Yes, proceed</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }} " type="text/css">
@stop
@section('js')
<script>
    $(document).ready(function() {
            var formToSubmit;
            console.log('js ready');

            // When the "Choose Plan" button is clicked
            $('.btn-sub').on('click', function(event) {
                event.preventDefault();

                // Find the form based on the index and store it
                formToSubmit = $(this).closest('form');

                // Show the modal
                $('#confirmationModal').modal('show');
            });

            // When the user confirms
            $('#confirmButton').on('click', function() {
                if (formToSubmit) {
                    console.log('this form');
                    formToSubmit.submit(); // Submit the stored form
                }
            });
        });
</script>

@endsection
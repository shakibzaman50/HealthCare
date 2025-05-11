@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer details</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $customer->name }}
                    </div>
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $customer->email }}
                    </div>
                    <div class="form-group">
                        <strong>Phone:</strong>
                        {{ $customer->phone }}
                    </div>
                    <div class="form-group">
                        <strong>Status:</strong>
                        {{ $customer->status }}
                    </div>
                    <div class="form-group">
                        <strong>Lifetime package:</strong>
                        {{ $customer->lifetimePackage?->name }}
                    </div>
                    <div class="form-group">
                        <strong>Monthly package:</strong>
                        {{ $customer->monthlyPackage?->name }}
                    </div>
                    <div class="form-group">
                        <strong>Referrer:</strong>
                        {{ $customer->leader?->name }}
                    </div>
                    <div class="form-group">
                        <strong>Balance:</strong>
                        {{ $customer->balance }}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subscribers</h3>
                </div>
                <div class="card-body">
                    @if ($customer->subscribers->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->subscribers as $subscriber)
                                    <tr>
                                        <td>{{ $subscriber->name }}</td>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>{{ $subscriber->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No subscribers yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

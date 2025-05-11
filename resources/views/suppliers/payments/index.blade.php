@extends('layouts/contentNavbarLayout')

@section('title', 'Payments List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Payment List</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active text-danger">Payment List</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Payment type</th>
                <th>Payment method</th>
                <th>Note</th>
                <th>Invoice ID</th>
                <th>Transaction id</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_type }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->note}}</td>
                <td>{{ $payment->invoice_id }}</td>
                <td>{{ $payment->transaction_id}}</td>
                <td>{{ $payment->creator->name ?? 0}}</td>
                <td>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<!--/ Contextual Classes -->
@endsection

<style>
    .btn-group .btn {
        margin-right: 5px;
        /* Adjust spacing between buttons */
    }

    .btn-group .btn:last-child {
        margin-right: 0;
        /* Remove right margin from the last button */
    }
</style>
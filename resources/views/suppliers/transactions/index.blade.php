@extends('layouts/contentNavbarLayout')

@section('title', 'Cards basic - UI elements')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card">

    <h5 class="card-header">Transaction List</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('suppliers.index') }}">Supplier</a>
                </li>
                <li class="breadcrumb-item active text-danger">Transaction List</li>
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
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Note</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplier->transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->transaction_type }}</td>
                <td>{{ $transaction->note }}</td>
                <td>{{ $transaction->creator->name}}</td>
                <td>{{ $transaction->created_at}}</td>
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
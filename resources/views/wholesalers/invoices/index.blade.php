@extends('layouts/contentNavbarLayout')

@section('title', 'Supplier List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Supplier Invoice List</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('wholesalers.index') }}">Wholesaler</a>
                </li>
                <li class="breadcrumb-item active text-danger">Invoice List</li>
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
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Payable Amount</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplier->supplier_invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->invoice_id }}</td>
                <td>{{ $invoice->date }}</td>
                <td>{{ $invoice->total }}</td>
                <td>{{ $invoice->discount }}</td>
                <td>{{ $invoice->payable_amount ?? 0}}</td>
                <td>{{ $invoice->paid ?? 0}}</td>
                <td>{{ $invoice->due ?? 0}}</td>
                <td>{{ $invoice->creator->name ?? 0}}</td>
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
@extends('layouts/contentNavbarLayout')

@section('title', 'Product Transfer Logs')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Product Transfer Logs</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Product</a>
                </li>
                <li class="breadcrumb-item active text-danger">Transfer Logs</li>
            </ol>
        </nav>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
        <div class="alert alert-primary">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card-body">
            <div class="divider">
                <div class="divider-text">
                    <h5>Product Details</h5>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <tr class="table-dark">
                <th>ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr class="table-primary">
                <th>Product Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr class="table-secondary">
                <th>Cold storage Quantity</th>
                <td><strong>{{ $product->cold_storage_quantity }}</strong> {{ $product->unit->name }}</td>
            </tr>
            <tr class="table-success">
                <th>Office Quantity</th>
                <td><strong>{{ $product->office_quantity }}</strong> {{ $product->unit->name }}</td>
            </tr>
            <tr class="table-warning">
                <th>Unit</th>
                <td>{{ $product->unit->name }}</td>
            </tr>
        </table>
        <div class="card-body">
            <div class="divider">
                <div class="divider-text">
                    <h5>Product Transfer Logs</h5>
                </div>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <tr>
                <th>ID</th>

                <th>Quantity</th>
                <th>Transfer From</th>
                <th>Transfer To</th>
                <th>Transfer Pre Quantity</th>
                <th>Transfer Post Quantity</th>
                <th>Received Pre Quantity</th>
                <th>Received Post Quantity</th>
                <th>Transfer By</th>
                <th>Reason</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
            @foreach ($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->transfer_from }}</td>
                <td>{{ $log->transfer_to }}</td>
                <td>{{ $log->transfer_pre_quantity}}</td>
                <td>{{ $log->transfer_post_quantity}}</td>
                <td>{{ $log->received_pre_quantity}}</td>
                <td>{{ $log->received_post_quantity}}</td>
                <td>{{ $log->creator->name}}</td>
                <td>{{ $log->reason}}</td>
                <td>{{ $log->created_at}}</td>
                <td>

                </td>
            </tr>
            @endforeach
        </table>
        {{-- <div>
            {{ $histories->histories->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div> --}}
    </div>
</div>
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('productCreateModal'));
        myModal.show();
    });
</script>
@endif
@endsection
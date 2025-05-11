@extends('layouts/contentNavbarLayout')

@section('title', 'Order List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Order List</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('wholesalers.index') }}">Orders</a>
                </li>
                <li class="breadcrumb-item active text-danger">List</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @include('orders.list-grid')
</div>
<!-- Modal Structure -->
<div class="modal fade" id="unavailableProductModal" tabindex="-1" aria-labelledby="unavailableProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog card">
        <div class="unavailable-product-modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="unavailableProductModalLabel">Un-Available Product Details</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="unavailable-product-modal-content">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
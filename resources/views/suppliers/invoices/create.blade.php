@extends('layouts/contentNavbarLayout')

@section('title', 'Supplier Product Invoice')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
'resources/assets/vendor/libs/tagify/tagify.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
'resources/assets/vendor/libs/moment/moment.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/typeahead-js/typeahead.js',
'resources/assets/vendor/libs/tagify/tagify.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/form-validation.js'])
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Supplier Product Invoice</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('suppliers.index') }}">Supplier</a>
                </li>
                <li class="breadcrumb-item active text-danger">List</li>
            </ol>
        </nav>
    </div>
    <form action="{{ route('supplier.invoice.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="store_id" class="form-label">Select Store</label>
                <select name="store_id" id="store_id" class="form-select select2" required>
                    @foreach($store_type as $key=>$value)
                    <option value="{{ $key }}">{{$value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 col-md-3">
                <label for="invoice_id" class="form-label">Invoice ID</label>
                <input type="text" name="invoice_id" id="invoice_id" class="form-control" required>
            </div>

            <div class="mb-3 col-md-3">
                <label for="user_id" class="form-label">Supplier</label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    @foreach($suppliers as $key=> $supplier)
                    <option value="{{ $key }}">{{ $supplier }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="invoice_type" value="{{ config('app.transaction_payable_type.supplier') }}">

            <div class="mb-3 col-md-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <h4>Products</h4>
            <div id="products">
                <div class="product-item mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="products[0][product_id]" class="form-label">Product</label>
                            <select name="products[0][product_id]" class="form-select product-select select2" required>
                                @foreach($products as $key=> $product)
                                <option value="{{ $key }}">{{ $product }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="products[0][quantity]" class="form-label">Quantity</label>
                            <input type="number" step="0.01" name="products[0][quantity]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="products[0][unit_price]" class="form-label">Buying Price</label>
                            <input type="number" step="0.01" name="products[0][unit_price]" class="form-control"
                                required>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addProductField()">Add Another Product</button>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="total" class="form-label">Total</label>
                <input type="number" step="0.01" name="total" id="total" class="form-control" required readonly>
            </div>

            <div class="mb-3 col-md-4">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" step="0.01" name="discount" id="discount" class="form-control">
            </div>

            <div class="mb-3 col-md-4">
                <label for="payable_amount" class="form-label">Payable Amount</label>
                <input type="number" step="0.01" name="payable_amount" id="payable_amount" class="form-control" required
                    readonly>
            </div>

            <div class="mb-3 col-md-4">
                <label for="paid" class="form-label">Paid</label>
                <input type="number" step="0.01" name="paid" id="paid" class="form-control">
            </div>

            <div class="mb-3 col-md-4">
                <label for="due" class="form-label">Due</label>
                <input type="number" step="0.01" name="due" id="due" class="form-control" required readonly>
            </div>
            <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
            <div class="mb-3 col-md-4">
                <label for="image" class="form-label">Invoice Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </form>
</div>

<script>
    let productIndex = 1;

    function addProductField() {
        const productsContainer = document.getElementById('products');
        const productField = document.createElement('div');

        productField.classList.add('product-item', 'mb-3');
        productField.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="products[${productIndex}][product_id]" class="form-label">Product</label>
                    <select name="products[${productIndex}][product_id]" class="form-select product-select" required>
                        @foreach($products as $key=>$product)
                        <option value="{{ $key }}">{{ $product }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="products[${productIndex}][quantity]" class="form-label">Quantity</label>
                    <input type="number" step="0.01" name="products[${productIndex}][quantity]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="products[${productIndex}][unit_price]" class="form-label">Buying Price</label>
                    <input type="number" step="0.01" name="products[${productIndex}][unit_price]" class="form-control" required>
                </div>
            </div>
        `;
        productsContainer.appendChild(productField);
        productIndex++;

        // Reapply Select2 to new product fields
        $('.product-select').select2({
            placeholder: 'Search for a product',
            allowClear: true
        });

        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#products .product-item').forEach(function (productItem) {
            const quantity = parseFloat(productItem.querySelector('input[name$="[quantity]"]').value) || 0;
            const buyingPrice = parseFloat(productItem.querySelector('input[name$="[unit_price]"]').value) || 0;
            total += (quantity * buyingPrice);
        });
        document.getElementById('total').value = total.toFixed(2);

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const payableAmount = total - discount;
        document.getElementById('payable_amount').value = payableAmount.toFixed(2);

        const paid = parseFloat(document.getElementById('paid').value) || 0;
        const due = payableAmount - paid;
        document.getElementById('due').value = due.toFixed(2);
    }

    // Recalculate on input change
    document.getElementById('products').addEventListener('input', calculateTotal);
    document.getElementById('discount').addEventListener('input', calculateTotal);
    document.getElementById('paid').addEventListener('input', calculateTotal);
    
    // Initialize Select2 on page load
    $(document).ready(function() {
        $('.product-select').select2({
            placeholder: 'Search for a product',
            allowClear: true
        });
    });
</script>
@endsection
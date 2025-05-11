@extends('layouts/contentNavbarLayout')

@section('title', 'Wholesaler Product Invoice')

@section('vendor-script')
<!-- Include jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@endsection

@section('content')
<div class="container">
    <h2>Edit Order #{{ $order->id }}</h2>

    <form action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <label for="status_id" class="col-sm-2 col-form-label">Order Status</label>
            <div class="col-sm-10">
                <input type="text" id="status_id" class="form-control-plaintext" value="{{ $order->status->name }}"
                    readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="delivery_company_id" class="col-sm-2 col-form-label">Delivery Company</label>
            <div class="col-sm-10">
                <select name="delivery_company_id" id="delivery_company_id" class="form-select">
                    @foreach($delivery_companies as $company)
                    <option value="{{ $company->id }}" {{ $order->delivery_company_id == $company->id ? 'selected' : ''
                        }}>
                        {{ $company->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="product_search" class="col-sm-2 col-form-label">Search Product</label>
            <div class="col-sm-10">
                <input type="text" id="product_search" class="form-control" placeholder="Type to search products...">
                <div id="product_suggestions" class="list-group mt-2"></div>
            </div>
        </div>

        <div id="products" class="card p-2">
            <h4>Products</h4>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Product</strong></div>
                <div class="col-sm-2"><strong>Quantity</strong></div>
                <div class="col-sm-2"><strong>Price</strong></div>
                <div class="col-sm-2"><strong>Total</strong></div>
            </div>

            @foreach($order->details as $detail)
            <div class="row product-item mb-3" data-product-id="{{ $detail->product->id }}">
                <input type="hidden" name="product_ids[]" value="{{ $detail->product->id }}">
                <div class="col-sm-4">
                    <input type="text" class="form-control-plaintext" readonly value="{{ $detail->product->name }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" step="any" name="quantities[]" class="form-control quantity-input"
                        value="{{ $detail->quantity }}">
                </div>
                <div class="col-sm-2">
                    <input type="number" name="unit_price[]" class="form-control price-input"
                        value="{{ $detail->unit_price }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control-plaintext product-total" readonly
                        value="{{ $detail->quantity * $detail->unit_price }}">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mb-3">
            <label for="total" class="col-sm-2 col-form-label">Total</label>
            <div class="col-sm-10">
                <input type="text" id="total" name="total" class="form-control-plaintext" readonly
                    value="{{ $order->total }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="delivery_charge" class="col-sm-2 col-form-label">Delivery Charge</label>
            <div class="col-sm-10">
                <input type="number" name="delivery_charge" id="delivery_charge" class="form-control"
                    value="{{ $order->delivery_charge }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="discount" class="col-sm-2 col-form-label">Discount</label>
            <div class="col-sm-10">
                <input type="number" name="discount" id="discount" class="form-control" value="{{ $order->discount }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="payable_amount" class="col-sm-2 col-form-label">Payable Amount</label>
            <div class="col-sm-10">
                <input type="text" name="payable_amount" id="payable_amount" class="form-control-plaintext" readonly
                    value="{{ $order->payable_amount }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="paid" class="col-sm-2 col-form-label">Paid</label>
            <div class="col-sm-10">
                <input type="number" name="paid" id="paid" class="form-control-plaintext" value="{{ $order->paid }}"
                    readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="due" class="col-sm-2 col-form-label">Due</label>
            <div class="col-sm-10">
                <input type="text" id="due" name="due" class="form-control-plaintext" readonly
                    value="{{ $order->due }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</div>

<script>
    let productsList = @json($products); // This should be an array of product objects

    // Add new product row
    function addProductField(productId, productName, productPrice) {
        const productItemHtml = `
            <div class="row product-item mb-3" data-product-id="${productId}">
                <input type="hidden" name="product_ids[]" value="${productId}">
                <div class="col-sm-4">
                    <input type="text" class="form-control-plaintext" readonly value="${productName}">
                </div>
                <div class="col-sm-2">
                    <input type="text" step="any" name="quantities[]" class="form-control quantity-input" value="1">
                </div>
                <div class="col-sm-2">
                    <input type="number" name="unit_price[]" class="form-control price-input" value="${productPrice}">
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control-plaintext product-total" readonly value="${productPrice}">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            </div>
        `;

        document.getElementById('products').insertAdjacentHTML('beforeend', productItemHtml);
        calculateTotal();

        // Attach event listeners for new rows
        attachListenersToInputs();
    }

    // Remove product row
    document.getElementById('products').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-item').remove();
            calculateTotal();
        }
    });

    // Calculate total, delivery charge, payable, and due amounts
    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('#products .product-item').forEach((item) => {
            const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(item.querySelector('.price-input').value) || 0;
            const itemTotal = quantity * unitPrice;
            total += itemTotal;

            // Update the total for the individual product
            item.querySelector('.product-total').value = itemTotal.toFixed(2);
        });

        // Update total amount
        const totalElement = document.getElementById('total');
        if (totalElement) {
            totalElement.value = total.toFixed(2);
        }

        // Calculate discount and other amounts
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const deliveryCharge = parseFloat(document.getElementById('delivery_charge').value) || 0;
        const payableAmount = total - discount + deliveryCharge;

        const payableAmountElement = document.getElementById('payable_amount');
        if (payableAmountElement) {
            payableAmountElement.value = payableAmount.toFixed(2);
        }

        const paid = parseFloat(document.getElementById('paid').value) || 0;
        const due = payableAmount - paid;
        const dueElement = document.getElementById('due');
        if (dueElement) {
            dueElement.value = due.toFixed(2);
        }
    }

    // Attach event listeners to quantity and price inputs
    function attachListenersToInputs() {
        document.querySelectorAll('.quantity-input, .price-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    }

    // Initialize event listeners on page load
    window.onload = function() {
        attachListenersToInputs();
    };

    // Product search functionality
    document.getElementById('product_search').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const suggestionsContainer = document.getElementById('product_suggestions');
        suggestionsContainer.innerHTML = ''; // Clear previous suggestions

        if (query.length > 1) {
            const filteredProducts = productsList.filter(product => product.name.toLowerCase().includes(query));

            filteredProducts.forEach(product => {
                const suggestionItem = document.createElement('a');
                suggestionItem.href = '#';
                suggestionItem.classList.add('list-group-item', 'list-group-item-action');
                suggestionItem.textContent = product.name;

                suggestionItem.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Add the product to the form
                    addProductField(product.id, product.name, product.price);

                    // Clear the search field explicitly
                    const searchField = document.getElementById('product_search');
                    searchField.value = '';

                    // Clear the suggestions list
                    suggestionsContainer.innerHTML = '';

                    // Refocus on the search field for a new search
                    searchField.focus();
                });

                suggestionsContainer.appendChild(suggestionItem);
            });
        }
    });
</script>

@endsection
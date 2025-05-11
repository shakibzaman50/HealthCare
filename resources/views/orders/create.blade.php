@extends('layouts/contentNavbarLayout')

@section('title', 'Create Customer Order')

@section('vendor-script')
<!-- Include jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@endsection

@section('content')
<div class="p-2">
    <h5 class="card-header">Create Order</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('wholesalers.index') }}">Wholesalers</a>
                </li>
                <li class="breadcrumb-item active text-danger">List</li>
            </ol>
        </nav>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="p-2">
        <form enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="store_id" value="office_quantity">
            <div class="mb-3 card p-2">
                <h4>Products</h4>
                <div class="mb-3">
                    <label for="product_search" class="form-label">Search Product</label>
                    <input type="text" id="product_search" class="form-control" placeholder="Type product name...">
                    <div id="product_suggestions" class="list-group mt-2"></div>
                </div>

                <div id="products">
                    <!-- Dynamic product rows will be added here -->
                </div>
            </div>

            <div class="mb-3 col-md-3">
                <label for="total_quantity" class="form-label">Total Quantity</label>
                <input type="number" id="total_quantity" class="form-control" readonly>
            </div>

            <div class="p-5">
                <div class="row">
                    <div class="col-md-6 card">
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" name="total" id="total" class="form-control" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" name="discount" id="discount" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="delivery_charge" class="form-label">Delivery Charge</label>
                            <input type="number" name="delivery_charge" id="delivery_charge" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="payable_amount" class="form-label">Payable Amount</label>
                            <input type="number" name="payable_amount" id="payable_amount" class="form-control" required
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="paid" class="form-label">Paid</label>
                            <input type="number" name="paid" id="paid" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="due" class="form-label">Due</label>
                            <input type="number" name="due" id="due" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="col-md-6 card">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        {{-- <div class="mb-3 col-md-3">
                            <label for="delivery_company_id" class="form-label">Select Delivery</label>
                            <select name="delivery_company_id" id="delivery_company_id" class="form-select form-control"
                                required>
                                @foreach($delivery_companies as $key=>$value)
                                <option value="{{ $value->id }}">{{$value->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" name="note" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Invoice</button>
        </form>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="unavailableProductModal" tabindex="-1" aria-labelledby="unavailableProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog card">
            <div class="unavailable-product-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unavailableProductModalLabel">Un-Available Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="unavailable-product-modal-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<script>
    let productIndex = 0;
    let productsList = @json($products);

    // Function to add product row
    function addProductField(productId, productName, price) {
        const productsContainer = document.getElementById('products');
        const productField = document.createElement('div');

        productField.classList.add('product-item', 'mb-3');
        productField.innerHTML = `
            <div class="row table">
                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <input type="text" name="products[${productIndex}][product_name]" class="form-control" value="${productName}" readonly>
                    <input type="hidden" name="products[${productIndex}][product_id]" value="${productId}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity-input" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Price</label>
                    <input type="number" name="products[${productIndex}][unit_price]" class="form-control price-input" value="${price}" required>
                </div>
                <div class="col-md-2  my-auto">
                    <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
                </div>
            </div>
        `;
        productsContainer.appendChild(productField);
        productIndex++;

        calculateTotal();
    }

    // Function to calculate total including delivery charge
    function calculateTotal() {
        let total = 0;
        let totalQuantity = 0;

        document.querySelectorAll('#products .product-item').forEach(function (productItem) {
            const quantity = parseFloat(productItem.querySelector('.quantity-input').value) || 0;
            const unitPrice = parseFloat(productItem.querySelector('.price-input').value) || 0;
            total += (quantity * unitPrice);
            totalQuantity += quantity;
        });

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('total_quantity').value = totalQuantity.toFixed(2);

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const payableAmount = total - discount;
        const deliveryCharge = parseFloat(document.getElementById('delivery_charge').value) || 0;
        const finalPayableAmount = payableAmount + deliveryCharge;

        document.getElementById('payable_amount').value = finalPayableAmount.toFixed(2);

        const paid = parseFloat(document.getElementById('paid').value) || 0;
        const due = finalPayableAmount - paid;
        document.getElementById('due').value = due.toFixed(2);
    }

    // Event listeners to recalculate totals
    document.getElementById('products').addEventListener('input', calculateTotal);
    document.getElementById('discount').addEventListener('input', calculateTotal);
    document.getElementById('delivery_charge').addEventListener('input', calculateTotal);
    document.getElementById('paid').addEventListener('input', calculateTotal);

    // Remove product field
    document.getElementById('products').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-product')) {
            event.target.closest('.product-item').remove();
            calculateTotal();
        }
    });

    // Product search handling
    $('#product_search').on('input', function () {
        const query = $(this).val().toLowerCase();
        const suggestionsContainer = $('#product_suggestions');
        suggestionsContainer.empty();

        const filteredProducts = productsList.filter(product => product.name.toLowerCase().includes(query));

        if (filteredProducts.length > 0) {
            filteredProducts.forEach(product => {
                const suggestionItem = $('<button>')
                    .addClass('list-group-item list-group-item-action')
                    .text(product.name)
                    .on('click', function () {
                        addProductField(product.id, product.name, product.price);
                        suggestionsContainer.empty();
                        $('#product_search').val('');
                    });
                suggestionsContainer.append(suggestionItem);
            });
        }
    });
</script>

<script>
    $(document).ready(function () {
        // Bind the form submit event
        $('form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize form data
            let formData = new FormData(this);

            $.ajax({
                url: '/orders', // Use the form action URL
                method: 'POST', // Use the form method (POST)
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Response is ',response);
                    // Check if the response status indicates errors
                    if(response.status == 400){
                        // Ensure response.data is an array
                        let products = response.data || []; // Adjust this based on the actual response structure
                        let modalContent = '';

                        products.forEach(function (item) {
                            modalContent += `
                                <div class="mb-3">
                                    <strong>Product Name:</strong> ${item.name}<br>
                                    <strong>Cold Storage Quantity:</strong> ${item.cold_storage_quantity}<br>
                                    <strong>Office Quantity:</strong> ${item.office_quantity}<br>
                                </div>
                            `;
                        });

                        // Insert content into the modal
                        $('#unavailable-product-modal-content').html(modalContent);

                        // Show the modal
                        $('#unavailableProductModal').modal('show');
                    } else {
                        // Insert content into the modal
                        $('#unavailableProductModalLabel').html('Order Done');
                        $('#unavailable-product-modal-content').html('Your Order Done Successfully');

                        // Show the modal
                        $('#unavailableProductModal').modal('show');
                        // Optionally, redirect or clear the form
                        setTimeout(function() {
                            window.location.href = '/report/order'; // Change to your desired route
                        }, 5000);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '\n'; // Display each error message
                    });
                    alert('Error: ' + errorMessage);
                }
            });
        });
    });
</script>
@endsection
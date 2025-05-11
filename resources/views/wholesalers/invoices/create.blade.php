@extends('layouts/layoutMaster')

@section('title', 'Wholesaler Product Invoice')

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
    <h5 class="card-header">Wholesaler Product Invoice</h5>
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
    <form enctype="multipart/form-data">
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
                <label for="user_id" class="form-label">Supplier</label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    @foreach($suppliers as $key=> $supplier)
                    <option value="{{ $key }}">{{ $supplier }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3 card">
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

        <!-- Total quantity field -->
        <div class="mb-3 col-md-3">
            <label for="total_quantity" class="form-label">Total Quantity</label>
            <input type="number" id="total_quantity" class="form-control" readonly>
        </div>

        <div class="card p-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 ">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" step="0.01" name="total" id="total" class="form-control" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="payable_amount" class="form-label">Payable Amount</label>
                        <input type="number" step="0.01" name="payable_amount" id="payable_amount" class="form-control"
                            required readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 ">
                        <label for="paid" class="form-label">Paid</label>
                        <input type="number" step="0.01" name="paid" id="paid" class="form-control">
                    </div>
                    <div class="mb-3 ">
                        <label for="due" class="form-label">Due</label>
                        <input type="number" step="0.01" name="due" id="due" class="form-control" required readonly>
                    </div>
                    <div class="mb-3 ">
                        <label for="note" class="form-label">Note</label>
                        <input type="text" name="note" id="note" class="form-control">
                    </div>
                </div>
                <input type="hidden" name="created_by" id="created_by" value="{{ auth()->id() }}">
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </form>
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

<script>
    let productIndex = 0;

    // Your products data
    let productsList = @json($products);

    // Function to add product row
    function addProductField(productId, productName, wholesell_price) {
        const productsContainer = document.getElementById('products');
        const productField = document.createElement('div');

        productField.classList.add('product-item', 'mb-3');
        productField.innerHTML = `
            <div class="row table">
                <div class="col-md-6">
                    <label class="form-label">Product</label>
                    <input type="text" name="products[${productIndex}][product_name]" class="form-control" value="${productName}" readonly>
                    <input type="hidden" name="products[${productIndex}][product_id]" value="${productId}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" step="0.01" name="products[${productIndex}][quantity]" class="form-control quantity-input" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Price</label>
                    <input type="number" step="0.01" name="products[${productIndex}][unit_price]" class="form-control price-input" value="${wholesell_price}" required>
                </div>
            </div>
        `;
        productsContainer.appendChild(productField);
        productIndex++;

        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        let totalQuantity = 0;
        document.querySelectorAll('#products .product-item').forEach(function (productItem) {
            const quantity = parseFloat(productItem.querySelector('.quantity-input').value) || 0;
            const buyingPrice = parseFloat(productItem.querySelector('.price-input').value) || 0;
            total += (quantity * buyingPrice);
            totalQuantity += quantity;
        });
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('total_quantity').value = totalQuantity.toFixed(2); // Update total quantity

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const payableAmount = total - discount;
        document.getElementById('payable_amount').value = payableAmount.toFixed(2);

        const paid = parseFloat(document.getElementById('paid').value) || 0;
        const due = payableAmount - paid;
        document.getElementById('due').value = due.toFixed(2);
    }

    // Function to search for products
    document.getElementById('product_search').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const suggestions = document.getElementById('product_suggestions');
        suggestions.innerHTML = ''; // Clear previous suggestions

        if (query.length > 1) {
            const filteredProducts = productsList.filter(product => {
                return product.name.toLowerCase().includes(query);
            });

            filteredProducts.forEach(product => {
                const productItem = document.createElement('a');
                productItem.classList.add('list-group-item', 'list-group-item-action');
                productItem.href = '#';
                productItem.textContent = product.name;
                productItem.onclick = function(e) {
                    e.preventDefault();
                    addProductField(product.id, product.name, product.wholesell_price);
                    document.getElementById('product_search').value = ''; // Clear the search input
                    suggestions.innerHTML = ''; // Clear suggestions
                };
                suggestions.appendChild(productItem);
            });
        }
    });

    // Recalculate on input change
    document.getElementById('products').addEventListener('input', calculateTotal);
    document.getElementById('discount').addEventListener('input', calculateTotal);
    document.getElementById('paid').addEventListener('input', calculateTotal);
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Bind the form submit event
        $('form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize form data
            let formData = new FormData(this);

            $.ajax({
                url: '/wholesaler/invoice', // Use the form action URL
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
                        // Handle success
                        $('#unavailableProductModalLabel').html('Success');
                        // Insert content into the modal
                        $('#unavailable-product-modal-content').html('Invoice saved successfully!');

                        // Show the modal
                        $('#unavailableProductModal').modal('show');
                        setTimeout(function() {
                            window.location.href = '/wholesaler/orders'; // Change to your desired route
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
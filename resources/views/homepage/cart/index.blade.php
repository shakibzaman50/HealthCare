@extends('layouts/layoutFront')

@section('title', 'Checkout')
<!-- Page Scripts -->
@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all product images
        let productImages = document.querySelectorAll('.product-img');

        productImages.forEach(function(img) {
            // Show the spinner image initially
            let spinner = img.parentElement.querySelector('.loading-spinner');
            spinner.style.display = 'block';

            // Create a new image object for loading
            let tempImg = new Image();
            tempImg.src = img.getAttribute('data-src');
            
            // Once the image is loaded, replace the src and remove the spinner
            tempImg.onload = function() {
                img.src = tempImg.src;
                img.style.opacity = 1; // Show the image
                spinner.style.display = 'none'; // Hide the spinner once the image is loaded
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        calculateTotals();
        function updateCart(itemId, quantity) {
            let row = $(`[data-item-id='${itemId}']`).closest('li');
            let price = parseFloat(row.find('.item-price').data('price'));
            let totalItemPrice = price * quantity;
            row.find('.item-total').text(`TK ${totalItemPrice.toFixed(2)}`);

            calculateTotals();
            updateHeader();

            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    item_id: itemId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    console.log('Cart updated successfully');
                },
                error: function (xhr) {
                    console.error(xhr.responseJSON.message);
                },
            });
        }

        function calculateTotals() {
            let totalPrice = 0;
            let totalQuantity = 0;

            $('.item-total').each(function () {
                totalPrice += parseFloat($(this).text().replace('TK', '').trim());
            });

            $('input[type="number"]').each(function () {
                totalQuantity += parseInt($(this).val());
            });

            let deliveryCharge = parseFloat($('input[name="deliveryOption"]:checked').val());
            totalPrice += deliveryCharge;

            $('#totalprice').text(`${totalPrice.toFixed(2)} TK.`);
            $('#total_qty').text(totalQuantity);
        }

        $('.btn-increment').on('click', function () {
            let inputField = $(this).siblings('input[type="number"]');
            let itemId = $(this).data('item-id');
            let newVal = parseInt(inputField.val()) + 1;
            inputField.val(newVal);
            updateCart(itemId, newVal);
        });

        $('.btn-decrement').on('click', function () {
            let inputField = $(this).siblings('input[type="number"]');
            let itemId = $(this).data('item-id');
            let currentVal = parseInt(inputField.val());
            if (currentVal > 1) {
                let newVal = currentVal - 1;
                inputField.val(newVal);
                updateCart(itemId, newVal);
            }
        });

        $('.remove-from-cart').on('click', function() {
            var itemId = $(this).data('item-id');
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    item_id: itemId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('li').has($(this).closest('li')).remove();
                    $('#cart-response').html('<div class="alert alert-success">' + response.message + '</div>');

                    Swal.fire("Remove Product from Cart");

                    // Redirect after 3 seconds
                    setTimeout(function() {
                        window.location.reload()
                    }, 3000); // 3000 milliseconds = 3 seconds
                   
                },
                error: function(xhr) {
                    $('#cart-response').html('<div class="alert alert-danger">Error: ' + xhr.responseJSON.error + '</div>');
                }
            });
        });

        $('input[name="deliveryOption"]').on('change', function () {
            calculateTotals();
        });

        function updateHeader() {
            $.ajax({
                url: '{{ route("cart.get") }}', // Replace with your route to get cart data
                method: 'GET',
                success: function(response) {
                    // Update cart count
                    $('.cart-count').text(response.totalItems);

                    // Update total price
                    $('.cart-total-price').text('৳ ' + response.totalPrice);

                    // You can dynamically load cart items into the dropdown here if needed
                },
                error: function(xhr) {
                    console.error('Could not load cart data');
                }
            });
        }

        function fetchUpdatedCart() {
            $.ajax({
                url: '{{ route("cart.show") }}',
                type: 'GET',
                success: function(cartContent) {
                    $('#cart-content').html(cartContent); // Inject updated cart content
                    var offcanvasElement = document.getElementById('cart-offcanvasEnd');
                }
            });
        }
    });

    $('#order_submit').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect form data
        var formData = new FormData(this); // Collect the form data including file inputs

        $.ajax({
            url: '{{ route("order.done") }}', // Backend route that handles form submission
            method: 'POST',
            data: formData,
            processData: false,  // Prevent jQuery from automatically processing the data
            contentType: false,  // Set content type to false for proper handling of FormData
            success: function(response) {
                // Optionally, clear the form fields
                $('#order_submit')[0].reset();
                // Optionally, display some feedback in the cart-modal-body or elsewhere
                $('.cart-modal-body').html('<p>Thank you for your order! We will contact you soon.</p>');
                Swal.fire("Thank you for your order! We will contact you soon.");

                // Redirect after 3 seconds
                setTimeout(function() {
                    window.location.href = '{{ route("pages-home") }}'; // Replace with your desired route
                }, 3000); // 3000 milliseconds = 3 seconds

            },
            error: function(xhr) {
                // Handle error response
                alert('Something went wrong! Please try again.');
                console.error(xhr.responseText); // Log the error for debugging
            }
        });
    });
</script>

@endsection
@section('content')
<section class="section-py bg-body first-section-pt">

    <div class="container mt-0 p-0">
        @if (!empty($carts))
        <div class="row">
            <div class="col-md-6">
                <h5>My Shopping Bag ({{ count($carts) }} Items) <a href="{{ route('cart.clear') }}"
                        class="btn-danger p-1 float-right rounded">Remove All X</a></h5>

            </div>
        </div>

        <ul class="list-group mb-4">
            @php
            $totalQuantity = 0;
            $totalPrice = 0;
            @endphp

            @foreach ($carts as $key => $item)
            @php
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
            @endphp
            <li class="list-group-item p-6">
                <div class="d-flex gap-4">
                    <div class="flex-shrink-0 d-flex align-items-center">
                        <img src="{{ asset('images/products/thumb/' . $item['image']) }}" alt="{{ $item['name'] }}"
                            class="w-px-100">
                    </div>
                    <div class="flex-grow-1">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="me-3 mb-2"><a href="javascript:void(0)" class="fw-medium"> <span
                                            class="text-heading">{{ $item['name'] }}</span></a></p>
                                <div class="read-only-ratings mb-2" data-rateyo-read-only="true"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary btn-decrement" type="button"
                                        data-item-id="{{ $key }}">-</button>
                                    <input type="number" class="form-control form-control-sm"
                                        value="{{ $item['quantity'] }}" min="1" max="5" data-item-id="{{ $key }}">
                                    <button class="btn btn-outline-secondary btn-increment" type="button"
                                        data-item-id="{{ $key }}">+</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-md-end">
                                    <div class=" mb-md-4"> <span class="text-primary item-price"
                                            data-price="{{ $item['price'] }}">TK {{ $item['price'] }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <span class="text-primary item-total">TK {{ $item['price'] * $item['quantity'] }}</span>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn-close btn-pinned remove-from-cart bg-danger"
                                    aria-label="Close" data-item-id="{{ $key }}"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Total Quantity</th>
                            <td id="total_qty">{{ $totalQuantity }}</td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td id="totalprice">{{ $totalPrice }} TK.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="modal-content p-4">
                    <div class="modal-header">
                        <h4 class="modal-title" id="customModalLabel">
                            ক্যাশ অন ডেলিভারি করতে আপনার নাম,ঠিকানা, মোবাইল নম্বর লিখুন 
                        </h4>
                    </div>

                    <div class="modal-body">
                        <form id="order_submit">
                            @csrf
                            <div class="my-4">
                                <h5>Delivery Process</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deliveryOption" value="120"
                                        id="outsideDhaka" checked>
                                    <label class="form-check-label" for="outsideDhaka">Outside Dhaka City 120 Tk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="70" name="deliveryOption"
                                        id="insideDhaka">
                                    <label class="form-check-label" for="insideDhaka">Inside Dhaka 70 Tk</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nameInput" name="name"
                                    placeholder="Your name">
                            </div>

                            <div class="mb-3">
                                <label for="phoneInput" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="phoneInput" name="phone"
                                    placeholder="Your Mobile Number">
                            </div>

                            <div class="mb-3">
                                <label for="addressInput" class="form-label">Address</label>
                                <input type="text" class="form-control" id="addressInput" name="address"
                                    placeholder="Your Address">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 p-2 rounded">অর্ডার কনফার্ম করতে ক্লিক করুন</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h2>No Product in Cart</h2>
        @endif
    </div>
</section>
@endsection
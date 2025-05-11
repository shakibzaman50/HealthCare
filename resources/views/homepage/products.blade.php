@extends('layouts/layoutFront')

@section('title', 'Products')

<!-- Vendor Styles -->

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
    $(document).ready(function() {
        $('.add-to-cart').on('click', function() {
            var productId = $(this).data('product-id');
            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1, // Default quantity for quick add
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                beforeSend: function() {
                    $('#loader_'+productId).show();
                },
                success: function(response) {
                    // console.log(response);
                    $('#cart-response').html('<div class="alert alert-success">' + response.message + '</div>');
                    // Fetch and update the cart content
                    $.ajax({
                        url: '{{ route("cart.show") }}', // Route to get updated cart content
                        type: 'GET',
                        success: function(cartContent) {
                            // console.log('cart show',cartContent);
                            $('#cart-content').html(cartContent); // Inject updated cart content

                            // Show the Offcanvas automatically
                            var offcanvasElement = document.getElementById('cart-offcanvasEnd');
                            var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                            offcanvas.show();

                            updateCart()
                        }
                    });
                },
                complete: function() {
                    $('#loader_'+productId).hide();
                },
                error: function(response) {
                    $('#cart-response').html('<div class="alert alert-danger">Error: ' + response.responseJSON.error + '</div>');
                    $('#loader_'+productId).hide();
                }
            });
        });
        function updateCart() {
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
    });
</script>
@endsection


@section('content')
<section class="bg-body mb-10">

    <div class="section-py bg-body first-section-pt">
        @include('homepage/content/product')
        @include('homepage.cart.show')
        <div id="cart-content">
            @include('homepage.cart.show')
        </div>

    </div>

</section>
@endsection
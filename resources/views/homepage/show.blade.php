@extends('layouts/layoutFront')

@section('title', $product->name )

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
                    $('#cart-response').html('<div class="alert alert-success">' + response.message + '</div>');
                    // Fetch and update the cart content
                    $.ajax({
                        url: '{{ route("cart.show") }}', // Route to get updated cart content
                        type: 'GET',
                        success: function(cartContent) {
                            // console.log(cartContent);
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
    });
</script>
<script>
    // Define updateCart function in global scope
    function updateCart() {
        $.ajax({
            url: '{{ route("cart.get") }}',
            method: 'GET',
            success: function(response) {
                // Update cart count
                $('.cart-count').text(response.totalItems);

                // Update total price
                $('.cart-total-price').text('৳ ' + response.totalPrice);
            },
            error: function(xhr) {
                console.error('Could not load cart data');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var buttons = document.getElementsByClassName('openModalButton');
        
        Array.from(buttons).forEach(function(button) {
            button.addEventListener('click', function () {    
                var productId = button.getAttribute('data-product-id');
                
                // Check if the item is already in cart
                $.ajax({
                    url: '{{ route("cart.get") }}',
                    method: 'GET',
                    success: function(cartResponse) {
                        let itemExists = false;
                        if (cartResponse.items) {
                            itemExists = Object.values(cartResponse.items).some(item => item.id == productId);
                        }

                        // Only add to cart if item doesn't exist
                        if (!itemExists) {
                            // First add to cart
                            $.ajax({
                                url: '{{ route("cart.add") }}',
                                type: 'POST',
                                data: {
                                    product_id: productId,
                                    quantity: 1,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    loadModalContent();
                                },
                                error: function(response) {
                                    alert('Error adding item to cart: ' + response.responseJSON.error);
                                }
                            });
                        } else {
                            // If item already exists, just load the modal
                            loadModalContent();
                        }
                    }
                });

                function loadModalContent() {
                    $.ajax({
                        url: '{{ route("order.modalContent") }}',
                        method: 'GET',
                        success: function (response) {
                            // Clear existing modal content first
                            $('#customModal .cart-modal-body').empty();
                            
                            // Insert new content
                            $('#customModal .cart-modal-body').html(response.modalContent);
                            
                            var myModal = new bootstrap.Modal(document.getElementById('customModal'), {
                                backdrop: 'static',
                                keyboard: false
                            });
                            myModal.show();

                            // Update cart display
                            updateCart();

                            // Rebind the delivery option change handler
                            bindDeliveryOptionChange();
                        },
                        error: function (xhr) {
                            alert('Something went wrong! Please try again.');
                        }
                    });
                }
            });
        });

        // Bind the close button functionality to close the modal
        document.getElementById('closeModalButton').addEventListener('click', function () {
            var myModalEl = document.getElementById('customModal');
            var modalInstance = bootstrap.Modal.getInstance(myModalEl); 
            modalInstance.hide();
            $('.modal-backdrop').remove();
        });

        // Bind the footer close button functionality to close the modal
        document.getElementById('closeModalFooterButton').addEventListener('click', function () {
            var myModalEl = document.getElementById('customModal');
            var modalInstance = bootstrap.Modal.getInstance(myModalEl); 
            modalInstance.hide();
            $('.modal-backdrop').remove();
        });

        // Function to bind "Remove from Cart" functionality
        function bindRemoveFromCart() {
            document.querySelectorAll('.remove-from-cart').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    var itemId = this.getAttribute('data-item-id');

                    $.ajax({
                        url: '{{ route("cart.remove") }}', // The route for removing items
                        method: 'POST',
                        data: {
                            item_id: itemId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            // console.log('card-remove-response ==>',response);
                            if (response) {
                                // Update the cart section
                                $('.cart').html(response.cart);

                                // Update the total section
                                $('.total').html(response.total);

                                // Rebind event for new cart items
                                bindRemoveFromCart();
                                bindDeliveryOptionChange();

                                // Show a success message if needed
                                alert(response.message);
                            }
                        },
                        error: function (xhr) {
                            alert('Something went wrong!');
                        }
                    });
                });
            });
        }

        // Handle the form submission with AJAX
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

                // Hide the modal and remove the backdrop
                var myModalEl = document.getElementById('customModal');
                var modalInstance = bootstrap.Modal.getInstance(myModalEl);
                modalInstance.hide();
                $('.modal-backdrop').remove(); // Remove any lingering backdrop

                // Optionally, display some feedback in the cart-modal-body or elsewhere
                $('.cart-modal-body').html('<p>Thank you for your order! We will contact you soon.</p>');
                Swal.fire("Thank you for your order! We will contact you soon.");
            },
            error: function(xhr) {
                // Handle error response
                alert('Something went wrong! Please try again.');
                console.error(xhr.responseText); // Log the error for debugging
            }
        });
    });
    });
</script>

@endsection


@section('content')
<section class="section-py bg-body first-section-pt">

    <div class="container">
        @include('homepage/product/view')
        @if(count($product->releted)>0)
        @include('homepage/content/releted-product')
        @endif
        @include('homepage.cart.show')
        <div id="cart-content">
            @include('homepage.cart.show')
        </div>
        @include('homepage.cart.order-page')
    </div>

</section>
@endsection
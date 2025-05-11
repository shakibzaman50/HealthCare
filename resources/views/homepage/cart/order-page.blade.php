<!-- Modal Structure -->
<div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="customModalLabel">
                    ক্যাশ অন ডেলিভারি করতে আপনার নাম,ঠিকানা, মোবাইল নম্বর লিখুন

                </h4>
                <button type="button" class="btn-close" id="closeModalButton" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="order_submit">
                    @csrf
                    <!-- Customer Information -->
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Your name">
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

                    <!-- Delivery Options -->
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
                    <div class="cart-modal-body"></div>
                    <!-- Order Button -->
                    <button type="submit" class="btn btn-primary w-100 mt-3 p-2 rounded">অর্ডার কনফার্ম করতে ক্লিক করুন
                    </button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalFooterButton">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Button to trigger AJAX request and show modal
    var buttons = document.getElementsByClassName('openModalButton');
    Array.from(buttons).forEach(function(button) {
        button.addEventListener('click', function () {     
            $.ajax({
                url: '{{ route("order.modalContent") }}', // Backend route to load modal content
                method: 'GET',
                success: function (response) {
                    // console.log(response.modalContent);
                    // Update the modal body with the new content
                    $('#customModal .cart-modal-body').html(response.modalContent);
                    
                    // Show the modal with options to prevent closing on backdrop or ESC key
                    var myModal = new bootstrap.Modal(document.getElementById('customModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();

                    // Rebind any necessary events after refreshing modal content
                    bindRemoveFromCart();
                    bindDeliveryOptionChange();
                },
                error: function (xhr) {
                    alert('Something went wrong! Please try again.');
                }
            });
        });
    });

    // Bind the close button functionality to close the modal
    document.getElementById('closeModalButton').addEventListener('click', function () {
        var myModalEl = document.getElementById('customModal');
        var modalInstance = bootstrap.Modal.getInstance(myModalEl); 
        modalInstance.hide();
    });

    // Bind the footer close button functionality to close the modal
    document.getElementById('closeModalFooterButton').addEventListener('click', function () {
        var myModalEl = document.getElementById('customModal');
        var modalInstance = bootstrap.Modal.getInstance(myModalEl); 
        modalInstance.hide();
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
                var myModalEl = document.getElementById('customModal');
                var modalInstance = bootstrap.Modal.getInstance(myModalEl); 
                modalInstance.hide();
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
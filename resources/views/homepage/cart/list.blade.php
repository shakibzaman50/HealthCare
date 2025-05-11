@if (!empty($carts))
<h5 class="mb-3">My Shopping Bag ({{ count($carts) }} Items)</h5>
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
    <li class="list-group-item p-3">
        <div class="d-flex gap-3">
            <div class="flex-shrink-0">
                <img src="{{ asset('images/products/thumb/' . $item['image']) }}" 
                     alt="{{ $item['name'] }}"
                     class="img-fluid"
                     style="max-width: 100px; height: auto;">
            </div>
            <div class="flex-grow-1">
                <div class="row g-2">
                    <div class="col-12 col-md-10">
                        <h6 class="mb-2">
                            <a href="javascript:void(0)" class="text-decoration-none text-dark">
                                {{ $item['name'] }}
                            </a>
                        </h6>
                        <div class="mb-3">
                            <span class="text-primary fw-bold me-2">৳{{ number_format($item['price'], 2) }}</span>
                            @if(isset($item['original_price']))
                            <s class="text-muted">৳{{ number_format($item['original_price'], 2) }}</s>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary btn-decrement px-2" 
                                        type="button"
                                        data-item-id="{{ $key }}">−</button>
                                <input type="number" 
                                       class="form-control text-center px-2" 
                                       value="{{ $item['quantity'] }}"
                                       min="1" 
                                       max="5" 
                                       data-item-id="{{ $key }}"
                                       style="width: 60px;">
                                <button class="btn btn-outline-secondary btn-increment px-2" 
                                        type="button"
                                        data-item-id="{{ $key }}">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex justify-content-end align-items-start">
                        <button type="button" 
                                class="btn-close remove-from-cart" 
                                aria-label="Close"
                                data-item-id="{{ $key }}"></button>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>

<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <span>Total Quantity:</span>
            <span class="fw-bold">{{ $totalQuantity }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Total Price:</span>
            <span class="fw-bold">৳{{ number_format($totalPrice, 2) }}</span>
        </div>
    </div>
</div>

<div class="d-grid">
    <a href="/cart" class="btn btn-success btn-lg">
        ক্যাশ অন ডেলিভারিতে অর্ডার করুন
    </a>
</div>

<script>
    $(document).ready(function() {
        function updateCart(itemId, quantity) {
            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    item_id: itemId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    fetchUpdatedCart(); // Fetch and update the cart content
                    updateHeader();
                },
                error: function(xhr) {
                    console.error(xhr.responseJSON.message);
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

        $('.btn-increment').on('click', function() {
            var inputField = $(this).siblings('input[type="number"]');
            var itemId = $(this).data('item-id');
            var newVal = parseInt(inputField.val()) + 1;
            inputField.val(newVal);
            updateCart(itemId, newVal);
        });

        $('.btn-decrement').on('click', function() {
            var inputField = $(this).siblings('input[type="number"]');
            var itemId = $(this).data('item-id');
            var currentVal = parseInt(inputField.val());
            if (currentVal > 1) {
                var newVal = currentVal - 1;
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
                    fetchUpdatedCart(); // Fetch and update the cart content
                },
                error: function(xhr) {
                    $('#cart-response').html('<div class="alert alert-danger">Error: ' + xhr.responseJSON.error + '</div>');
                }
            });
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
    });
</script>

@endif
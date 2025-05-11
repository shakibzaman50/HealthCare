@if (!empty($carts))
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5>My Shopping Bag ({{ count($carts) }} Items)</h5>
            </div>
            <div class="col-md-6">
                <a href="{{ route('cart.clear') }}" class="btn-danger p-2 float-right">Remove All</a>

            </div>
        </div>

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
                    <div class="col-md-6">
                        <p class="me-3 mb-2"><a href="javascript:void(0)" class="fw-medium"> <span
                                    class="text-heading">{{ $item['name'] }}</span></a></p>

                        <div class="read-only-ratings mb-2" data-rateyo-read-only="true"></div>

                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-decrement" type="button"
                                data-item-id="{{ $key }}">-</button>
                            <input type="number" class="form-control form-control-sm" value="{{ $item['quantity'] }}"
                                min="1" max="5" data-item-id="{{ $key }}">
                            <button class="btn btn-outline-secondary btn-increment" type="button"
                                data-item-id="{{ $key }}">+</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-md-end">

                            <div class=" mb-md-4"> <span class="text-primary">TK {{ $item['price']
                                    }}/</span>
                                <s class="text-body">TK 300</s>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <button type="button" class="btn-close btn-pinned remove-from-cart" aria-label="Close"
                            data-item-id="{{ $key }}"></button>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-2">
        <button type="button" class="btn-success p-2 rounded openModalButton">ক্যাশ অন
            ডেলিভারিতে অর্ডার
            করুন</button>
    </div>
    <div class="col-md-6">
        <table class="table">
            <tbody>
                <tr>
                    <th>Total Quantity</th>
                    <td>{{ $totalQuantity }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>{{ $totalPrice }} TK.</td>
                </tr>
            </tbody>

        </table>
    </div>
</div>


@else
<h2>No Product in Cart</h2>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    updateCart();
                },
                error: function(xhr) {
                    $('#cart-response').html('<div class="alert alert-danger">Error: ' + xhr.responseJSON.error + '</div>');
                }
            });
        });
    });
</script>
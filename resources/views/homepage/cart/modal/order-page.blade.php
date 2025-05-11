@if (!empty($carts))

<div class="row">
    <div class="col-md-6">
        <h5>My Shopping Bag ({{ count($carts) }} Items)</h5>
    </div>
    <div class="col-md-6">
        <a href="{{ route('cart.clear') }}" class="btn-danger p-2 float-right">Remove All</a>

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
    <div class="col-md-12">
        <table class="table">
            <tbody>
                <tr>
                    <th>Total Quantity</th>
                    <td id="totalQuantity">{{ $totalQuantity }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td id="totalPrice">{{ $totalPrice + 120 }} TK.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="p-4">
            <form id="order_submit">
                @csrf
                <!-- Delivery Options -->
                <div class="my-4">
                    <h5>ডেলিভারি প্রসেস</h5>
                    <div class="form-check">
                        <input class="form-check-input deliveryOption" type="radio" name="deliveryOption" value="120"
                            id="outsideDhaka" checked>
                        <label class="form-check-label" for="outsideDhaka">ঢাকা শহরের বাইরে ১২০ টাকা</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input deliveryOption" type="radio" value="70" name="deliveryOption"
                            id="insideDhaka">
                        <label class="form-check-label" for="insideDhaka">ঢাকা শহরের ভিতর ৭০ টাকা</label>
                    </div>
                </div>
                <!-- Customer Information -->
                <div class="mb-3">
                    <label for="nameInput" class="form-label">নাম</label>
                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="আপনার নাম লিখুন">
                </div>
                <div class="mb-3">
                    <label for="phoneInput" class="form-label">মোবাইল</label>
                    <input type="text" class="form-control" id="phoneInput" name="phone"
                        placeholder="আপনার মোবাইল নং লিখুন">
                </div>
                <div class="mb-3">
                    <label for="addressInput" class="form-label">ঠিকানা</label>
                    <input type="text" class="form-control" id="addressInput" name="address"
                        placeholder="আপনার ঠিকানা লিখুন">
                </div>
                <!-- Order Button -->
                <button type="submit" class="btn btn-primary w-100 mt-3 p-2 rounded">অর্ডার করুন </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deliveryOptions = document.querySelectorAll('.deliveryOption');
        const totalPriceElement = document.getElementById('totalPrice');
        const basePrice = {{ $totalPrice }}; // Base total price without delivery fee

        // Function to update the total price
        function updateTotalPrice() {
            const selectedOption = document.querySelector('.deliveryOption:checked');
            const deliveryFee = parseInt(selectedOption.value);
            const updatedTotalPrice = basePrice + deliveryFee;
            totalPriceElement.textContent = `${updatedTotalPrice} TK.`;
        }

        // Add change event listener to each delivery option
        deliveryOptions.forEach(option => {
            option.addEventListener('change', updateTotalPrice);
        });

        // Initialize total price on page load
        updateTotalPrice();
    });
</script>



@else
<h2>No Product in Cart</h2>
@endif
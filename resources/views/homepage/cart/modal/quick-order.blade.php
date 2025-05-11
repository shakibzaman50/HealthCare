<div class="cart-modal-body">

    <!-- Cart Section -->
    <div class="cart mb-4">
        @php
        $carts = session()->get('cart', []);
        $totalQuantity = 0;
        $totalPrice = 0;
        
        // Calculate totals correctly
        foreach($carts as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }
        @endphp

        @if (!empty($carts))
        <h5>My Shopping Bag ({{ count($carts) }} Items)</h5>
        <ul class="list-group">
            @foreach ($carts as $key => $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/products/thumb/' . $item['image']) }}" alt="{{ $item['name'] }}"
                        width="50" class="me-3">
                    <div>
                        <p class="mb-0">
                            <strong>{{ $item['name'] }}</strong> (x{{ $item['quantity'] }})<br>
                            <span class="text-primary">{{ $item['price'] }}/</span> <s class="text-muted">300</s>
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-pinned remove-from-cart" aria-label="Close"
                    data-item-id="{{ $key }}"></button>
            </li>
            @endforeach
        </ul>
        @endif
        <!-- Total Calculation -->
        <div class="total">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Sub Total</th>
                        <td id="sub_total">{{ $totalPrice }}</td>
                    </tr>
                    <tr>
                        <th>Delivery Charge</th>
                        <td id="delivery_charge">0</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td id="final_total">{{ $totalPrice }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function bindDeliveryOptionChange() {
        // Get the initial subtotal from the displayed value
        const subTotalElement = document.getElementById('sub_total');
        let subTotal = parseFloat(subTotalElement.textContent) || 0;

        function updateTotals(deliveryCharge) {
            deliveryCharge = parseFloat(deliveryCharge) || 0;
            
            // Calculate final total
            const finalTotal = subTotal + deliveryCharge;
            
            // Update displays
            document.getElementById('delivery_charge').textContent = deliveryCharge;
            document.getElementById('final_total').textContent = finalTotal;
        }

        // Add event listeners to radio buttons
        const deliveryOptions = document.querySelectorAll('input[name="deliveryOption"]');
        deliveryOptions.forEach(option => {
            option.addEventListener('change', function() {
                let deliveryCharge = 0;
                
                if (this.id === 'outsideDhaka') {
                    deliveryCharge = 120;
                } else if (this.id === 'insideDhaka') {
                    deliveryCharge = 70;
                }
                
                updateTotals(deliveryCharge);
            });
        });

        // Set initial values based on selected option
        const selectedOption = document.querySelector('input[name="deliveryOption"]:checked');
        if (selectedOption) {
            let initialDeliveryCharge = 0;
            if (selectedOption.id === 'outsideDhaka') {
                initialDeliveryCharge = 120;
            } else if (selectedOption.id === 'insideDhaka') {
                initialDeliveryCharge = 70;
            }
            updateTotals(initialDeliveryCharge);
        } else {
            // Default to 0 delivery charge if nothing is selected
            updateTotals(0);
        }
    }

    // Initialize when the modal content is loaded
    bindDeliveryOptionChange();
</script>
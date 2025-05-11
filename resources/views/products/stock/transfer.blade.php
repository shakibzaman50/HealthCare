<div class="mt-4">
    <h5 class="modal-title">{{ $product->name }} Transfer Product</h5>
    <div class="modal-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{route('product.stock.transfer') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="mb-3">
                <label for="from_store_id" class="form-label">From Store</label>
                <select name="from_store_id" id="from_store_id" class="form-select select2" required>
                    @foreach($store_type as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="to_store_id" class="form-label">To Store</label>
                <select name="to_store_id" id="to_store_id" class="form-select select2" required>
                    @foreach($store_type as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="available_qty" class="form-label">Available Quantity</label>
                <input type="number" step="0.01" name="available_qty" id="available_qty" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Transfer Quantity</label>
                <input type="number" step="0.01" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Transfer</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Convert the product data to a JavaScript object
        var productData = @json($product);

        // Log the product data to see its structure
        console.log('Product Data:', productData);

        // Event listener for when the "from_store_id" dropdown changes
        $('#from_store_id').on('change', function() {
            var fromStoreId = $(this).val();
            
            // Log the current store ID
            console.log(`From Store ID: ${fromStoreId}`);

            // Check if productData exists and select the quantity based on fromStoreId
            var quantity;
            if (productData) {
                // Choose the quantity property based on the fromStoreId
                if (fromStoreId === 'cold_storage_quantity') {
                    quantity = productData.cold_storage_quantity;
                    $('#available_qty').val(quantity);

                } else if (fromStoreId === 'office_quantity') {
                    quantity = productData.office_quantity;
                    $('#available_qty').val(quantity);

                } else {
                    quantity = 'Unknown store';
                    $('#available_qty').val(0);

                }
                console.log('Selected Quantity:', quantity);
            } else {
                console.log('No product data found.');
            }
        });

        // Event listener for when the "from_store_id" or "to_store_id" dropdown changes
        $(document).on('change', '#from_store_id, #to_store_id', function() {
            var fromStoreId = $('#from_store_id').val();
            var toStoreId = $('#to_store_id').val();

            if (fromStoreId && toStoreId && fromStoreId === toStoreId) {
                alert('From Store and To Store cannot be the same.');
                $(this).val(''); // Reset the selection
            }
        });

        // Event listener for when the "quantity" input changes
        $('#quantity').on('input', function() {
            console.log('Hello');
            var availableQty = parseFloat($('#available_qty').val());
            var transferQty = parseFloat($(this).val());

            if (transferQty > availableQty) {
                alert('You cannot transfer more than you have available.');
                $(this).val(''); // Clear the input
            }
        });
    });
</script>
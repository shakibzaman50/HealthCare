@extends('layouts/contentNavbarLayout')

@section('title', 'Order List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<form action="{{ route('import.payment.order.csv') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import CSV</button>
</form>

<h1>Imported CSV Data</h1>
<form id="paymentSheetForm" action="{{ route('process.payment.data') }}" method="POST">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Payment Amount</th>
                <th>Order Due</th>
            </tr>
        </thead>
        <tbody>
            @php
            $unadjustable_orders = []; // Initialize the unadjustable orders array
            @endphp
            @foreach ($data as $row)
            @php
            // Check if the payment amount does not match the order due
            if (isset($row['order']) && $row[1] != $row['order']->due) {
            $unadjustable_orders[] = $row[0];
            }
            @endphp
            <tr
                class="{{ (isset($row['order']) && $row[1] != $row['order']->due) ? 'border-danger' : 'border-success' }}">
                <td
                    class="{{ (isset($row['order']) && $row[1] != $row['order']->due) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                    {{ $row[0] }}
                </td>
                <td>{{ $row[1] }}</td>
                <td>{{ isset($row['order']) ? $row['order']->due : 'N/A' }}</td> <!-- Order Due -->
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card">
        @if(count($unadjustable_orders) > 0)
        <p class="bg-danger text-white p-2 text-center"> {{ count($unadjustable_orders) }} Orders payment amount does
            not match order dues</p>
        @endif
        <input type="hidden" name="payment_data" value="{{ (json_encode($data)) }}">
        <input type="hidden" name="unadjustable_orders" value="{{ (json_encode($unadjustable_orders)) }}">
        <div class="container">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="payment_process_type">Payment Process Type</label>
                    <select name="payment_process_type" id="payment_process_type" class="form-control">
                        <option value="1">Only Valid Payment Process</option>
                        <option value="2">Submit Anyway</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <button type="submit" class="btn btn-success">Payment Process</button>
            </div>
        </div>
    </div>
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
                <div id="unavailable-product-modal-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Submit form using AJAX
        $('#paymentSheetForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Serialize the form data
            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // Use the form's action attribute
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Response:', response);
                    if (response.status === 200) {
                        $('#unavailableProductModal').modal('show');
                        $('#unavailableProductModalLabel').html('Processed successfully.');
                        $('#unavailable-product-modal-content').html(response.orders);
                    }
                    // Handle success (display success message, etc.)
                },
                error: function (xhr) {
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
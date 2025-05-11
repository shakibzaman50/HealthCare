@extends('layouts/contentNavbarLayout')

@section('title', 'Wholesaler Product Invoice')

@section('vendor-script')
<!-- Include jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@endsection

@section('content')
<form id="courierSheetForm">
    @csrf
    <div class="container">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="total_quantity" class="form-label">Sheet ID</label>
                <input type="text" class="form-control" name="invoice">
            </div>
            <div class="mb-3 col-md-3">
                <label for="delivery_company_id" class="form-label">Select Delivery</label>
                <select name="delivery_company_id" id="delivery_company_id" class="form-select form-control" required>
                    @foreach($delivery_companies as $key=>$value)
                    <option value="{{ $value->id }}">{{$value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="number" class="form-control">
            </div>
        </div>
    </div>
    <h2>Search Orders by Order Number</h2>
    <div class="form-group">
        <input type="text" id="orderSearch" class="form-control" placeholder="Enter order number" autocomplete="off">
    </div>
    <div class="card">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Rows will be appended here -->
            </tbody>
        </table>
    </div>

    </div>
    <button type="submit" id="courierSheetStore" class="btn btn-success">Shipped</button>
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
    // Search for orders on Enter key press
    $('#orderSearch').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault(); // Prevent form submission when pressing Enter

            let orderNumber = $(this).val();
            if (orderNumber.length > 0) {
                $.ajax({
                    url: '{{ route('orders.search') }}',
                    method: 'GET',
                    data: {
                        search: orderNumber
                    },
                    success: function(order) {
                        if(order.status == 400){
                            $('#unavailableProductModal').modal('show');
                            $('#unavailableProductModalLabel').html('Sorry');
                            $('#unavailable-product-modal-content').html(order.message);
                        } else {
                            $('#orderTableBody').append(`
                                <tr>
                                    <input type="hidden" name="orders[]" value="${order.id}">
                                    <td>${order.id}</td>
                                    <td>${order.customer.name}</td>
                                    <td>${order.total}</td>
                                    <td>${order.status.name}</td>
                                </tr>
                            `);
                        }
                        // Clear the input field
                        $('#orderSearch').val('');
                    },
                    error: function() {
                        alert('Order not found.');
                    }
                });
            }
        }
    });

    // Submit form only when Shipped button is clicked
    $('#courierSheetStore').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Serialize the form data
        let formData = new FormData($('#courierSheetForm')[0]);

        $.ajax({
            url: '/store/courier/sheet', // Adjust this to your actual route
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Response is ', response);
                if(response.status == 200){
                    $('#unavailableProductModal').modal('show');
                    $('#unavailableProductModalLabel').html('Done');
                    $('#unavailable-product-modal-content').html(response.message);
                }
                // Handle success (display success message, etc.)
            },
            error: function (xhr, status, error) {
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
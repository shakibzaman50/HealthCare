<!-- Change Button -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#orderInvoiceStatusModal_{{ $order->id }}">
    Change
</button>

<!-- Large Modal -->
<div class="modal fade" id="orderInvoiceStatusModal_{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mx-auto p-4">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="orderStatusForm_{{ $order->id }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Status Dropdown -->
                            <div class="mb-3 col-md-3">
                                <label for="status_id" class="form-label">Select Status</label>
                                <select name="status_id" id="status_id" class="form-select" required>
                                    @foreach($statuses as $key => $status)

                                    <option value="{{ $status->id }}" {{ $status->id==$order->status_id ? 'selected' :
                                        '' }}>
                                        {{ $status->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Delivery Company Dropdown -->
                            <div class="mb-3 col-md-3">
                                <label for="delivery_company_id" class="form-label">Select Delivery</label>
                                <select name="delivery_company_id" id="delivery_company_id" class="form-select"
                                    required>
                                    @foreach($delivery_companies as $key => $company)
                                    <option value="{{ $key }}" {{ $key==$order->delivery_company_id ? 'selected' : ''
                                        }}>
                                        {{ $company }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="due" value="{{ $order->due }}">

                            <!-- Paid Input Field -->
                            <div class="mb-3 col-md-3">
                                <label for="paid" class="form-label">Paid (Due: {{ $order->due }} TK.)</label>
                                <input type="number" name="newPaid" id="paid" class="form-control">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <input type="submit" class=" p-2 btn-info" value="Update">
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Bind the form submit event
        $('#orderStatusForm_{{ $order->id }}').on('submit', function (e) {
            e.preventDefault();
            
            var orderId = {{ $order->id }}; // Capture the order ID dynamically
            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "/orders/status/update/" + orderId , // Update with your correct route
                type: "POSt",
                data: formData,
                success: function (response) {
                    console.log(response);
                    let modalContent = '';
                    if(response.status == 400){
                        

                        if(response.data){
                            // Ensure response.data is an array
                            let products = response.data || []; // Adjust this based on the actual response structure
                            let modalContent = '';

                            products.forEach(function (item) {
                                modalContent += `
                                    <h4>Un-Available Product Details</h4>
                                    <div class="mb-3">
                                        <strong>Product Name:</strong> ${item.name}<br>
                                        <strong>Cold Storage Quantity:</strong> ${item.cold_storage_quantity}<br>
                                        <strong>Office Quantity:</strong> ${item.office_quantity}<br>
                                    </div>
                                `;
                            });

                            // Insert content into the modal
                            $('#unavailable-product-modal-content').html(modalContent);

                            // Show the modal
                            $('#unavailableProductModal').modal('show');
                        }else{
                            modalContent += `
                                   <h4>${response.message}</h4> 
                                `;
                            $('#unavailable-product-modal-content').html(modalContent);
                            $('#unavailableProductModal').modal('show');
                        }
                    
                    } else {
                        location.reload();
                        // Handle success
                        modalContent += `
                                   <h4>${response.message}</h4> 
                                `;
                            $('#unavailable-product-modal-content').html(modalContent);
                            $('#unavailableProductModal').modal('show');
                             // Handle success response
                            $('#orderInvoiceStatusModal_' + orderId).modal('hide'); // Uncomment to close modal on success
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText); // Log the error
                    alert('Error: ' + xhr.responseText); // Show error message
                }
            });
        });
    });
</script>
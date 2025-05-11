@extends('layouts/layoutMaster')

@section('title', 'Order Report')

<!-- Vendor Styles -->

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/moment/moment.js',
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js',
'resources/assets/vendor/libs/cleavejs/cleave.js',
'resources/assets/vendor/libs/cleavejs/cleave-phone.js'
])
@endsection

@section('page-script')
@vite('resources/assets/js/app-ecommerce-customer-all.js')
@endsection

@section('content')
<div class="card p-2">
    <h4>Order List</h4>
    <form method="GET" action="{{ route('report.order') }}" class="mb-4">
        <div class="row">
            <div class="col-md-2">
                <label class="form-label">Time Period</label>
                <select name="filter" onchange="toggleDateInputs(this.value)" class="form-control">
                    <option value="">-- Select Time Period --</option>
                    <option value="today" {{ request('filter')=='today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('filter')=='yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="this_week" {{ request('filter')=='this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="last_week" {{ request('filter')=='last_week' ? 'selected' : '' }}>Last Week</option>
                    <option value="this_month" {{ request('filter')=='this_month' ? 'selected' : '' }}>This Month
                    </option>
                    <option value="last_month" {{ request('filter')=='last_month' ? 'selected' : '' }}>Last Month
                    </option>
                    <option value="custom" {{ request('filter')=='custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <div class="col-md-2" id="date-range-inputs"
                style="display: {{ request('filter') == 'custom' ? 'block' : 'none' }};">
                <label class="form-label">Date Range</label>
                <div class="d-flex gap-2">
                    <input type="date" name="start_date" class="form-control" placeholder="Start Date"
                        value="{{ request('start_date') }}">
                    <input type="date" name="end_date" class="form-control" placeholder="End Date"
                        value="{{ request('end_date') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label">Order Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ request('status')==$status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Delivery Company</label>
                <select name="delivery_company" class="form-control">
                    <option value="">All Companies</option>
                    @foreach($delivery_companies as $key => $company)
                    <option value="{{ $key }}" {{ request('delivery_company')==$key ? 'selected' : '' }}>
                        {{ $company }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Apply Filter
                </button>
                <a href="{{ route('report.order') }}" class="btn btn-secondary">
                    <i class="fas fa-undo me-2"></i>Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Add Bulk Action Controls -->
    <div class="bulk-actions mb-3 d-flex gap-2 align-items-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="selectAll">
            <label class="form-check-label" for="selectAll">Select All</label>
        </div>

        <!-- Status Dropdown -->
        <select id="bulkStatus" class="form-select" style="width: 200px;">
            <option value="">Change Status</option>
            @foreach($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>

        <!-- Delivery Company Dropdown -->
        <select id="bulkDelivery" class="form-select" style="width: 200px;">
            <option value="">Change Delivery Company</option>
            @foreach($delivery_companies as $key=> $company)
            <option value="{{ $key }}">{{ $company }}</option>
            @endforeach
        </select>

        <button type="button" id="applyBulkStatus" class="btn btn-primary" disabled>
            Apply Changes
        </button>

        <!-- Add Print Button -->
        <button type="button" id="printSelectedInvoices" class="btn btn-info" disabled>
            <i class="fas fa-print me-2"></i>Print Invoices
        </button>
    </div>

    <!-- Add Print Frame (hidden) -->
    <iframe id="printFrame" style="display: none;"></iframe>

    <div class="card-datatable table-responsive">
        @include('orders.list-grid')
    </div>
</div>

<script>
    function toggleDateInputs(filter) {
        var dateRangeInputs = document.getElementById('date-range-inputs');
        dateRangeInputs.style.display = filter === 'custom' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const bulkStatus = document.getElementById('bulkStatus');
        const bulkDelivery = document.getElementById('bulkDelivery');
        const applyBulkBtn = document.getElementById('applyBulkStatus');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const printBtn = document.getElementById('printSelectedInvoices');

        // Toggle all checkboxes
        selectAll.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButton();
        });

        // Update bulk action button state
        function updateBulkActionButton() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const hasSelection = checkedBoxes.length > 0;
            applyBulkBtn.disabled = !hasSelection;
            printBtn.disabled = !hasSelection;
        }

        // Listen to individual checkbox changes
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionButton);
        });

        // Handle bulk updates
        applyBulkBtn.addEventListener('click', function() {
            const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
                .map(cb => cb.value);
            
            const statusId = document.getElementById('bulkStatus').value;
            const deliveryId = document.getElementById('bulkDelivery').value;
            
            if (selectedOrders.length === 0 || (!statusId && !deliveryId)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Selection',
                    text: 'Please select orders and either a status or delivery company to update'
                });
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to update the selected orders",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Prepare the data
                    const formData = {
                        order_ids: selectedOrders,
                        status_id: statusId || null,
                        delivery_company_id: deliveryId || null,
                        _token: '{{ csrf_token() }}'
                    };

                    // Show processing message
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Updating orders',
                        icon: 'info',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request
                    fetch('/orders/status/bulk-update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let message = data.message;
                            if (data.steadfast_status) {
                                message += '\n' + data.steadfast_message;
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Error updating orders'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error updating orders'
                        });
                    });
                }
            });
        });

        // Add print functionality
        printBtn.addEventListener('click', function() {
            const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
                .map(cb => cb.value);
            
            if (selectedOrders.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Orders Selected',
                    text: 'Please select orders to print'
                });
                return;
            }

            // Show loading message
            Swal.fire({
                title: 'Preparing invoices...',
                text: 'Please wait while we prepare your invoices',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Load all invoices in one page
            const printFrame = document.getElementById('printFrame');
            printFrame.src = `/orders/invoice?ids=${selectedOrders.join(',')}`;
            
            // Handle print completion
            printFrame.onload = function() {
                Swal.close();
            };
        });
    });
</script>
@endsection
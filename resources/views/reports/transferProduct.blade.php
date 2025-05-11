@extends('layouts/layoutMaster')

@section('title', 'Product Transfer Report')

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
    <h4>Transfer Product List</h4>
    <form method="GET" action="{{ route('report.product.transfer') }}" class="mb-4">

        <div class="row">
            <div class="col-md-3">
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

            <!-- Show custom date fields if 'custom' filter is selected -->
            <div class="col-md-3" id="date-range-inputs"
                style="display: {{ request('filter') == 'custom' ? 'block' : 'none' }};">
                <input type="date" name="start_date" class="form-control mb-2" placeholder="Start Date"
                    value="{{ request('start_date') }}">
                <input type="date" name="end_date" class="form-control" placeholder="End Date"
                    value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3" id="status-inputs">
                <select name="storage" class="form-control">

                    <option value=""> -- Select Storage --</option>
                    <option value="cold_storage_quantity" {{ request('storage')=='cold_storage_quantity' ? 'selected'
                        : '' }}>
                        Cold Storage
                    </option>
                    <option value="office_quantity" {{ request('storage')=='office_quantity' ? 'selected' : '' }}>
                        Office Storage
                    </option>

                </select>
            </div>

            <div class="col-md-1 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            <div class="col-md-2 align-self-end">
                <a href="{{ route('report.product.buy') }}" class="btn btn-primary">Clear</a>
            </div>
        </div>
    </form>

    <div class="card-datatable table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Tr. Pre Qty</th>
                    <th>TR. Post Qty</th>
                    <th>Re. Pre Qty</th>
                    <th>Re. Post Qty</th>
                    <th>Transfer By</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->created_at }} </td>
                    <td>{{ $invoice->id }} </td>
                    <td>{{ $invoice->product->name }} </td>
                    <td>{{ $invoice->quantity }} </td>
                    <td>{{ $invoice->transfer_from }} </td>
                    <td>{{ $invoice->transfer_to }} </td>
                    <td>{{ $invoice->transfer_pre_quantity }} </td>
                    <td>{{ $invoice->transfer_post_quantity }} </td>
                    <td>{{ $invoice->received_pre_quantity }} </td>
                    <td>{{ $invoice->received_post_quantity }} </td>
                    <td>{{ $invoice->creator->name }} </td>
                    <td>{{ $invoice->reason }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
<script>
    function toggleDateInputs(filter) {
        var dateRangeInputs = document.getElementById('date-range-inputs');
        if (filter === 'custom') {
            dateRangeInputs.style.display = 'block';
        } else {
            dateRangeInputs.style.display = 'none';
        }
    }
</script>
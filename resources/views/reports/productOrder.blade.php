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
    <h4>Order Product List</h4>
    <form method="GET" action="{{ route('report.product.order') }}" class="mb-4">

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
                <select name="status" class="form-control">
                    @foreach($statuses as $key => $status)
                    <option value="{{ $key }}" {{ request('status')==$key ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-1 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            <div class="col-md-2 align-self-end">
                <a href="{{ route('report.product.order') }}" class="btn btn-primary">Clear</a>
            </div>
        </div>
    </form>

    <div class="card-datatable table-responsive">
        {{-- @include('orders.list-grid') --}}

        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order['product_name'] }} </td>
                    <td>{{ $order['total_quantity'] }} KG.</td>
                    <td>{{ $order['unit_price'] }} Tk.</td>
                    <td>{{ $order['total_revenue'] }} Tk.</td>
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
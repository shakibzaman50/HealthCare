@extends('layouts/layoutMaster')

@section('title', 'Activity Log')

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
    <h4>Customer Login Log</h4>
    <form method="GET" action="{{ route('userBehave-activity-log') }}" class="mb-4">

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

            <div class="col-md-1 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            <div class="col-md-2 align-self-end">
                <a href="{{ route('userBehave-activity-log') }}" class="btn btn-primary">Clear</a>
            </div>
        </div>
    </form>

    <div class="card-datatable table-responsive">
        <table class="datatables-activity-logs table border-top">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Account</th>
                    <th>IP Address</th>
                    <th>Activity</th>

                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ optional($log->causer)->name ?? 'N/A' }}</td>
                    <td>{{ $log->properties['ip'] ?? 'N/A' }}</td>
                    <td>{{ $log->description }}</td>
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
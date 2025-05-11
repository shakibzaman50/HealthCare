@extends('layouts/contentNavbarLayout')

@section('title', 'Wholesaler Product Invoice')

@section('vendor-script')
<!-- Include jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <form action="" method="GET">
            <div class="row mb-4">

                <!-- Time Period Dropdown -->
                <div class="col-md-3">
                    <label for="filter">Select Time Period:</label>
                    <select name="filter" id="filter" onchange="toggleDateInputs(this.value)" class="form-control">
                        <option value="">-- Select Time Period --</option>
                        <option value="today" {{ request('filter')=='today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ request('filter')=='yesterday' ? 'selected' : '' }}>Yesterday
                        </option>
                        <option value="this_week" {{ request('filter')=='this_week' ? 'selected' : '' }}>This Week
                        </option>
                        <option value="last_week" {{ request('filter')=='last_week' ? 'selected' : '' }}>Last Week
                        </option>
                        <option value="this_month" {{ request('filter')=='this_month' ? 'selected' : '' }}>This Month
                        </option>
                        <option value="last_month" {{ request('filter')=='last_month' ? 'selected' : '' }}>Last Month
                        </option>
                        <option value="custom" {{ request('filter')=='custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                <!-- Custom Date Range Inputs -->
                <div class="col-md-3" id="customDateRange" style="display: none;">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-3" id="customDateRangeEnd" style="display: none;">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>

                <!-- Filter Button -->
                <div class="col-md-2 mt-7">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                {{-- <div class="col-md-2 mt-7">
                    <a href="{{ route('rollPermission-access-logs') }}" class="btn btn-danger">Reset</a>
                </div> --}}
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>ID</th>
                    <th>Courier Name</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($sheets as $sheet)
                <tr>
                    <td>{{ $sheet->created_at }}</td>
                    <td>{{ $sheet->id }}</td>
                    <td>{{ $sheet->company->name }}</td>
                    <td>
                        <a class="btn-primary p-2 rounded text-white cursor-pointer" data-bs-toggle="modal"
                            id="mediumButton" data-target="#mediumModal"
                            data-attr="{{ route('courier_sheet_view',$sheet->id) }}" title="View"> View
                        </a>
                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>
        <div class="d-flex justify-content-between">
            <div>
                Showing {{ $sheets->count() }} of {{ $sheets->total() }} records
            </div>
            <div>
                {{ $sheets->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" id="mediumBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show/hide custom date range inputs based on the selected filter
        function toggleDateInputs(value) {
            const customRangeInputs = document.getElementById('customDateRange');
            const customRangeEndInputs = document.getElementById('customDateRangeEnd');
            
            if (value === 'custom') {
                customRangeInputs.style.display = 'block';
                customRangeEndInputs.style.display = 'block';
            } else {
                customRangeInputs.style.display = 'none';
                customRangeEndInputs.style.display = 'none';
            }
        }

        // On page load, check if the 'custom' option is selected
        document.addEventListener('DOMContentLoaded', function () {
            const filterValue = document.getElementById('filter').value;
            toggleDateInputs(filterValue);
        });
</script>
<script>
    $(document).on('click', '#mediumButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#mediumModal').modal("show");
                $('#mediumBody').html(result).show();
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        })
    });
</script>
@endsection
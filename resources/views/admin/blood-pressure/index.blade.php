@extends('layouts/layoutMaster')

@section('title', 'Blood Pressure Records')

@section('vendor-style')
@vite('resources/assets/vendor/libs/select2/select2.scss')
@vite('resources/assets/vendor/libs/toastr/latest/toastr.min.css')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/select2/select2.js')
@vite('resources/assets/vendor/libs/toastr/latest/toastr.min.js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Configure toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize Select2
        $('.select2').select2({
            placeholder: "Search for a profile...",
            allowClear: true
        });

        // Select all functionality
        $('#selectAll').change(function() {
            $('.record-checkbox').prop('checked', $(this).prop('checked'));
            updateButtons();
        });

        $('.record-checkbox').change(function() {
            updateButtons();
        });

        function updateButtons() {
            const checkedCount = $('.record-checkbox:checked').length;
            $('#bulkDeleteBtn').prop('disabled', checkedCount === 0);
            $('#exportSelectedBtn').prop('disabled', checkedCount === 0);
        }

        // Export selected records
        $('#exportSelectedBtn').click(function() {
            const selectedIds = $('.record-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('export_csv', '1');
                currentUrl.searchParams.set('selected_ids', selectedIds.join(','));
                window.location.href = currentUrl.toString();
            }
        });

        // Bulk delete functionality
        $('#bulkDeleteBtn').click(function() {
            const selectedIds = $('.record-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete selected!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.blood-pressures.bulk-delete") }}',
                            method: 'POST',
                            data: {
                                ids: selectedIds
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error('Delete error:', xhr);
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message || 'An error occurred while deleting records',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        });

        // Single delete functionality
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/blood-pressures/${id}`,
                        method: 'DELETE',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.error('Delete error:', xhr);
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'An error occurred while deleting the record',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Blood Pressures Records</h3>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form id="filterForm" method="GET" action="{{ route('admin.blood-pressures.index') }}" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="profile_id">Profile Name</label>
                            <select class="form-control select2" id="profile_id" name="profile_id">
                                <option value="">All Profiles</option>
                                @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}" {{ request('profile_id')==$profile->id ? 'selected' :
                                    '' }}>
                                    {{ $profile->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary me-1">Filter</button>
                                <a class="btn btn-danger" href="{{ route('admin.blood-pressures.index') }}">Clear</a>
                                <button type="button" class="btn btn-success mt-2" id="exportSelectedBtn" disabled>Export
                                    Selected</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="bloodPressureTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Profile</th>
                            <th>Systolic</th>
                            <th>Diastolic</th>
                            <th>Unit</th>
                            <th>Measured At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bloodPressures as $bloodPressure)
                        <tr>
                            <td>
                                <input type="checkbox" class="record-checkbox" value="{{ $bloodPressure->id }}">
                            </td>
                            <td>{{ $bloodPressure->profile->name ?? 'N/A' }}</td>
                            <td>{{ $bloodPressure->systolic }}</td>
                            <td>{{ $bloodPressure->diastolic }}</td>
                            <td>{{ $bloodPressure->unit->name ?? 'N/A' }}</td>
                            <td>{{ Helper::formattedDateTime($bloodPressure->measured_at) }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $bloodPressure->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <button class="btn btn-danger" id="bulkDeleteBtn" disabled>Delete Selected</button>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts/contentNavbarLayout')

@section('title', 'Blood Sugar Records')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/toastr/latest/toastr.min.css')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/select2/select2.js')
    @vite('resources/assets/vendor/libs/toastr/latest/toastr.min.js')
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize Select2 with proper configuration
            $('.select2').select2({
                width: '100%',
                placeholder: "Search for a profile...",
                allowClear: true
            });

            // Handle select all checkbox with direct event binding
            $(document).on('change', '#selectAll', function () {
                const isChecked = $(this).prop('checked');
                $('.record-checkbox').each(function () {
                    $(this).prop('checked', isChecked);
                });
                updateButtons();
            });

            // Handle individual checkboxes with direct event binding
            $(document).on('change', '.record-checkbox', function () {
                updateSelectAllCheckbox();
                updateButtons();
            });

            function updateSelectAllCheckbox() {
                const totalCheckboxes = $('.record-checkbox').length;
                const checkedCheckboxes = $('.record-checkbox:checked').length;
                $('#selectAll').prop({
                    'checked': totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes,
                    'indeterminate': checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes
                });
            }

            function updateButtons() {
                const checkedCount = $('.record-checkbox:checked').length;
                $('#exportSelectedBtn, #bulkDeleteBtn').prop('disabled', checkedCount === 0);
                
                // Update counter badge
                $('#selectedCount').text(checkedCount);
                $('#selectedCountWrapper').toggle(checkedCount > 0);
            }

            // Handle export selected
            $('#exportSelectedBtn').on('click', function () {
                const selectedIds = $('.record-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Records Selected',
                        text: 'Please select at least one record to export.'
                    });
                    return;
                }

                window.location.href = `/admin/blood-sugars/bulk-export?selectedIds=${selectedIds.join(',')}`;
            });

            // Handle bulk delete
            $('#bulkDeleteBtn').on('click', function() {
                const selectedIds = $('.record-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) return;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${selectedIds.length} records. This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/blood-sugars/bulk-delete',
                            type: 'DELETE',
                            data: { ids: selectedIds },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Selected records have been deleted successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Something went wrong!'
                                });
                            }
                        });
                    }
                });
            });

            // Handle delete record with direct event binding
            $(document).on('click', '.delete-record', function () {
                const button = $(this);
                const url = button.data('url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Record has been deleted successfully.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Something went wrong!'
                                });
                            }
                        });
                    }
                });
            });

            // Initial state update
            updateSelectAllCheckbox();
            updateButtons();
        });
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Blood Sugar Records</h5>
            <div id="selectedCountWrapper" style="display: none;" class="badge bg-info">
                <span id="selectedCount">0</span> items selected
            </div>
        </div>

        <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">
            <form action="{{ route('admin.blood-sugars.index') }}" class="d-flex" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="profile" class="form-label">Profile Name</label>
                            <select name="filter[profile_id]" id="profile" class="form-select select2">
                                <option value="">Search for a profile...</option>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}" {{ request('filter.profile_id') == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @php
                        $date = [
                            "filter" => [
                                "date" => implode(',', [request('filter.start_date'), request('filter.end_date')])
                            ]
                        ];
                    @endphp

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="filter[date][0]"
                                value="{{ $date['filter']['date'] }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="filter[date]"
                                value="{{ request('filter.date') }}">
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                        </button>
                        <a href="{{ route('admin.blood-sugars.index') }}" class="btn btn-danger">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-end gap-2 mb-3">
                <button type="button" class="btn btn-danger" id="bulkDeleteBtn" disabled>
                    <i class="fa fa-trash"></i>
                </button>
                <button type="button" class="btn btn-success" id="exportSelectedBtn" disabled>
                    <i class="fa fa-download"></i>
                </button>
            </div>
        </div>

            @if(session('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>PROFILE</th>
                            <th>BLOOD SUGAR</th>
                            <th>UNIT</th>
                            <th>MEASURED AT</th>
                            <th>SCHEDULE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bloodSugars as $bsRecord)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input record-checkbox"
                                        value="{{ $bsRecord->id }}">
                                </td>
                                <td>{{ $bsRecord->profile->name ?? 'N/A' }}</td>
                                <td>{{ $bsRecord->value }}</td>
                                <td>{{ $bsRecord->sugarUnit->name ?? 'N/A' }}</td>
                                <td>{{ $bsRecord->measured_at ? $bsRecord->measured_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                <td>{{ $bsRecord->sugarSchedule->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $bsRecord->status == 'Low Sugar' ? 'bg-danger' : 'bg-success' }}">
                                        {{ $bsRecord->status }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-sm btn-danger delete-record"
                                        data-id="{{ $bsRecord->id }}"
                                        data-url="{{ route('admin.blood-sugars.destroy', $bsRecord->id) }}"
                                        title="Delete Record">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing <span class="fw-semibold">{{ $bloodSugars->firstItem() ?? 0 }}</span> to 
                    <span class="fw-semibold">{{ $bloodSugars->lastItem() ?? 0 }}</span> of
                    <span class="fw-semibold">{{ $bloodSugars->total() }}</span> entries
                </div>
                <div class="pagination-container">
                    {{ $bloodSugars->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
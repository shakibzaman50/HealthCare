@extends('layouts/contentNavbarLayout')

@section('title', 'Blood Sugar Records')


@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/toastr/latest/toastr.min.css')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/select2/select2.js')
    @vite('resources/assets/vendor/libs/toastr/latest/toastr.min.js')

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
                updateExportButton();
            });

            // Handle individual checkboxes with direct event binding
            $(document).on('change', '.record-checkbox', function () {
                updateSelectAllCheckbox();
                updateExportButton();
            });

            function updateSelectAllCheckbox() {
                const totalCheckboxes = $('.record-checkbox').length;
                const checkedCheckboxes = $('.record-checkbox:checked').length;
                $('#selectAll').prop({
                    'checked': totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes,
                    'indeterminate': checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes
                });
            }

            function updateExportButton() {
                const checkedCount = $('.record-checkbox:checked').length;
                $('#exportSelectedBtn').prop('disabled', checkedCount === 0);
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

                window.location.href = `{{ route('admin.bs-records.bulk-export') }}?ids=${selectedIds.join(',')}`;
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
            updateExportButton();
        });
    </script>
@endsection

@section('content')
    <h2 class="mb-4">Blood Sugar Records</h2>

    <div class="container-fluid p-0">
        <form action="{{ route('admin.bs-records.index') }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
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

                @php
                    $date = [
                        "filter" => [
                            "date" => implode(',', [request('filter.start_date'), request('filter.end_date')])
                        ]
                    ];
                @endphp

                <div class="col-md-3">
                    <label for="start_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="start_date" name="filter[date][0]"
                        value="{{ $date['filter']['date'] }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="filter[date]"
                        value="{{ request('filter.date') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.bs-records.index') }}" class="btn btn-danger">Clear</a>
                    <button type="button" class="btn btn-success" id="exportSelectedBtn" disabled>Export Selected</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
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
                    <table class="table table-striped">
                        <thead>
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
                            @forelse($bsRecords as $bsRecord)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input record-checkbox"
                                            value="{{ $bsRecord->id }}">
                                    </td>
                                    <td>{{ $bsRecord->profile->name ?? 'N/A' }}</td>
                                    <td>{{ $bsRecord->value }}</td>
                                    <td>{{ $bsRecord->sugarUnit->name ?? 'N/A' }}</td>
                                    <td>{{ $bsRecord->measured_at ? $bsRecord->measured_at->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td>{{ $bsRecord->sugarSchedule->name ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill {{ $bsRecord->status == 'Low Sugar' ? 'bg-danger' : 'bg-success' }}">{{ $bsRecord->status }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-record"
                                            data-id="{{ $bsRecord->id }}"
                                            data-url="{{ route('admin.bs-records.destroy', $bsRecord->id) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $bsRecords->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
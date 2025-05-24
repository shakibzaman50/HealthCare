@extends('layouts/layoutMaster')

@section('title', 'Medication Records')

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
            $('#selectAll').change(function () {
                $('.record-checkbox').prop('checked', $(this).prop('checked'));
                updateButtons();
            });

            $('.record-checkbox').change(function () {
                updateButtons();
            });

            function updateButtons() {
                const checkedCount = $('.record-checkbox:checked').length;
                $('#bulkDeleteBtn').prop('disabled', checkedCount === 0);
                $('#exportSelectedBtn').prop('disabled', checkedCount === 0);
            }

            // Export selected records
            $('#exportSelectedBtn').click(function () {
                const selectedIds = $('.record-checkbox:checked').map(function () {
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
            $('#bulkDeleteBtn').click(function () {
                const selectedIds = $('.record-checkbox:checked').map(function () {
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
                                url: '{{ route("admin.medications.bulk-delete") }}',
                                method: 'POST',
                                data: {
                                    ids: selectedIds
                                },
                                success: function (response) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.message,
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function (xhr) {
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
            $(document).on('click', '.delete-btn', function (e) {
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
                            url: `/admin/medications/${id}`,
                            method: 'DELETE',
                            success: function (response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
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

            // Toggle status functionality
            $(document).on('click', '.toggle-status', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                const button = $(this);

                $.ajax({
                    url: `/admin/config/medication/${id}/toggle-status`,
                    method: 'POST',
                    success: function (response) {
                        if (response.success) {
                            const badge = button.closest('tr').find('.status-badge');
                            if (response.is_active) {
                                badge.removeClass('bg-danger').addClass('bg-success').text('Active');
                                button.removeClass('btn-success').addClass('btn-warning').text('Deactivate');
                            } else {
                                badge.removeClass('bg-success').addClass('bg-danger').text('Inactive');
                                button.removeClass('btn-warning').addClass('btn-success').text('Activate');
                            }
                            toastr.success(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error('Toggle status error:', xhr);
                        toastr.error(xhr.responseJSON?.message || 'An error occurred while updating status');
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
                <h3 class="card-title">Medication Records</h3>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form id="filterForm" method="GET" action="{{ route('admin.medications.index') }}" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="profile_id">Profile Name</label>
                                <select class="form-control select2" id="profile_id" name="profile_id">
                                    <option value="">All Profiles</option>
                                    @foreach($profiles as $profile)
                                        <option value="{{ $profile->id }}" {{ request('profile_id') == $profile->id ? 'selected' : '' }}>
                                            {{ $profile->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="medicine_type">Medicine Type</label>
                                <select class="form-control" id="medicine_type" name="medicine_type">
                                    <option value="">All Types</option>
                                    @foreach($medicineTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('medicine_type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    placeholder="Medicine name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button type="button" id="bulkDeleteBtn" class="btn btn-danger" disabled>
                            <i class="fas fa-trash"></i> Delete Selected
                        </button>
                        <button type="button" id="exportSelectedBtn" class="btn btn-success" disabled>
                            <i class="fas fa-download"></i> Export Selected
                        </button>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Medicine Name</th>
                                <th>Type</th>
                                <th>Strength</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Reminders</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $medicine)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="record-checkbox" value="{{ $medicine->id }}">
                                    </td>
                                    <td>{{ $medicine->id }}</td>
                                    <td>{{ $medicine->profile->name ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $medicine->name }}</strong>
                                        @if($medicine->notes)
                                            <br><small class="text-muted">{{ Illuminate\Support\Str::limit($medicine->notes, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $medicine->medicineType->name ?? 'N/A' }}</td>
                                    <td>{{ $medicine->strength }}</td>
                                    <td>{{ $medicine->medicineUnit->name ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge status-badge {{ $medicine->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $medicine->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $medicine->reminders_count ?? 0 }}</span>
                                    </td>
                                    <td>{{ $medicine->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.medications.show', $medicine->id) }}"
                                                class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-sm {{ $medicine->is_active ? 'btn-warning' : 'btn-success' }} toggle-status"
                                                data-id="{{ $medicine->id }}"
                                                title="{{ $medicine->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas {{ $medicine->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $medicine->id }}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No medication records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="text-muted">
                        <span class="fw-semibold">{{ $medicines->total() }}</span> total results | 
                        Showing <span class="fw-semibold">{{ $medicines->firstItem() ?? 0 }}</span> to 
                        <span class="fw-semibold">{{ $medicines->lastItem() ?? 0 }}</span>
                    </div>
                    <div class="pagination-container">
                        {{ $medicines->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
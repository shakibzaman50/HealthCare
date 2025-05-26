@extends('layouts/layoutMaster')

@section('title', 'Medication Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Medication Information</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.medications.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Medicine Name:</th>
                                        <td><strong>{{ $medicine->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Profile:</th>
                                        <td>{{ $medicine->profile->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type:</th>
                                        <td>{{ $medicine->medicineType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Strength:</th>
                                        <td>{{ $medicine->strength }} {{ $medicine->medicineUnit->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge {{ $medicine->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $medicine->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Created At:</th>
                                        <td>{{ $medicine->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At:</th>
                                        <td>{{ $medicine->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Reminders:</th>
                                        <td>
                                            <span class="badge bg-info">{{ $medicine->reminders->count() }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($medicine->notes)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Notes:</h5>
                                    <div class="alert alert-info">
                                        {{ $medicine->notes }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-{{ $medicine->is_active ? 'warning' : 'success' }}"
                                onclick="toggleStatus({{ $medicine->id }})">
                                <i class="fas {{ $medicine->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                {{ $medicine->is_active ? 'Deactivate' : 'Activate' }} Medicine
                            </button>
                            <button type="button" class="btn btn-danger" onclick="deleteMedicine({{ $medicine->id }})">
                                <i class="fas fa-trash"></i> Delete Medicine
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($medicine->reminders->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Reminders & Schedules</h3>
                        </div>
                        <div class="card-body">
                            @foreach($medicine->reminders as $reminder)
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            Reminder #{{ $reminder->id }}
                                            @if($reminder->is_repeat)
                                                <span class="badge bg-primary">Repeating</span>
                                            @endif
                                            @if($reminder->till_turn_off)
                                                <span class="badge bg-warning">Until Turn Off</span>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>End Date:</strong>
                                                    {{ $reminder->end_date ? $reminder->end_date->format('M d, Y') : 'Not set' }}
                                                </p>
                                                <p><strong>Is Repeat:</strong> {{ $reminder->is_repeat ? 'Yes' : 'No' }}</p>
                                                <p><strong>Till Turn Off:</strong> {{ $reminder->till_turn_off ? 'Yes' : 'No' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Created:</strong> {{ $reminder->created_at->format('M d, Y H:i') }}</p>
                                                <p><strong>Schedules:</strong> {{ $reminder->schedules->count() }}</p>
                                            </div>
                                        </div>

                                        @if($reminder->schedules->count() > 0)
                                            <h6 class="mt-3">Schedules:</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Schedule Type</th>
                                                            <th>How Many Times</th>
                                                            <th>Schedule Times</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($reminder->schedules as $schedule)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-secondary">{{ $schedule->schedule_type?->value ?? 'N/A' }}</span>
                                                                </td>
                                                                <td>{{ $schedule->how_many_times ?? 'N/A' }}</td>
                                                                <td>
                                                                    @if($schedule->scheduleTimes->count() > 0)
                                                                        @foreach($schedule->scheduleTimes as $time)
                                                                            <span class="badge bg-info me-1">
                                                                                {{ $time->time?->format('H:i') ?? 'N/A' }}
                                                                                @if($time->label)
                                                                                    ({{ $time->label }})
                                                                                @endif
                                                                            </span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">No times set</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function toggleStatus(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will change the medicine status.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.medications.toggle-status", ["id" => $medicine->id]) }}',
                        method: 'POST',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(
                                    'Updated!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function (xhr) {
                            console.error('Toggle status error:', xhr);
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'An error occurred while updating status',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function deleteMedicine(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! This will also delete all related reminders and schedules.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.medications.destroy", ["id" => $medicine->id]) }}',
                        method: 'DELETE',
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.href = '{{ route("admin.medications.index") }}';
                            });
                        },
                        error: function (xhr) {
                            console.error('Delete error:', xhr);
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'An error occurred while deleting the medicine',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
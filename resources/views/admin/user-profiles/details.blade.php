@extends('layouts/layoutMaster')

@section('title', 'Profile Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Details</h4>
                <div class="d-flex gap-1">
                    <a href="{{ route('user-profiles.show', $user) }}" class="btn btn-secondary btn-sm">
                        Back to Profiles
                    </a>
                    <a href="{{ route('user-profiles.index') }}" class="btn btn-secondary btn-sm">
                        Back to Users
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Basic Profile Information -->
                <div class="row mb-4">
                    <div class="col-md-4 text-center mb-3">
                        <img src="{{ $profile->avatar_url }}" alt="Profile Avatar" class="rounded-circle img-fluid"
                            style="max-width: 200px;">
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Basic Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $profile->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Age:</th>
                                        <td>{{ $profile->age }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender:</th>
                                        <td>{{ $profile->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Birth Year:</th>
                                        <td>{{ $profile->birth_year }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Physical Information</h5>
                                <table class="table">
                                    <tr>
                                        <th>Weight:</th>
                                        <td>{{ $profile->weight }} {{ $profile->weightUnit->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Height:</th>
                                        <td>{{ $profile->height }} {{ $profile->heightUnit->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>BMI:</th>
                                        <td>{{ $profile->bmi }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Metrics Tabs -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#assessment" role="tab">
                                    <i class="ti ti-clipboard-check me-1"></i>Assessment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#blood-pressure" role="tab">
                                    <i class="ti ti-heartbeat me-1"></i>Blood Pressure
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#blood-oxygen" role="tab">
                                    <i class="ti ti-wind me-1"></i>Blood Oxygen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#heart-rate" role="tab">
                                    <i class="ti ti-pulse me-1"></i>Heart Rate
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#hydration" role="tab">
                                    <i class="ti ti-droplet me-1"></i>Hydration
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Assessment Tab -->
                            <div class="tab-pane fade show active" id="assessment" role="tabpanel">
                                @if($profile->assessment)
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Activity Level:</th>
                                            <td>{{ $profile->assessment->activityLevel->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Physical Condition:</th>
                                            <td>{{ $profile->assessment->physicalCondition->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Live Active Lifestyle:</th>
                                            <td>{{ $profile->assessment->live_active_lifestyle ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Insulin Resistance:</th>
                                            <td>{{ $profile->assessment->insulin_resistance ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hypertension:</th>
                                            <td>{{ $profile->assessment->hypertension ? 'Yes' : 'No' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hydration Goal:</th>
                                            <td>{{ $profile->assessment->hydration_goal ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                @else
                                <p class="text-muted">No assessment data available.</p>
                                @endif
                            </div>

                            <!-- Blood Pressure Tab -->
                            <div class="tab-pane fade" id="blood-pressure" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Systolic</th>
                                                <th>Diastolic</th>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($profile->bloodPressures()->latest()->paginate(10) as $bp)
                                            <tr>
                                                <td>{{ $bp->measured_at }}</td>
                                                <td>{{ $bp->systolic }}</td>
                                                <td>{{ $bp->diastolic }}</td>
                                                <td>{{ $bp->unit->name }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No blood pressure records found.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $profile->bloodPressures()->latest()->paginate(10)->links() }}
                                </div>
                            </div>

                            <!-- Blood Oxygen Tab -->
                            <div class="tab-pane fade" id="blood-oxygen" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Oxygen Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($profile->bloodOxygens()->latest()->paginate(10) as $bo)
                                            <tr>
                                                <td>{{ $bo->measured_at }}</td>
                                                <td>{{ $bo->oxygen_level }}%</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center">No blood oxygen records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $profile->bloodOxygens()->latest()->paginate(10)->links() }}
                                </div>
                            </div>

                            <!-- Heart Rate Tab -->
                            <div class="tab-pane fade" id="heart-rate" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Heart Rate</th>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($profile->heartRates()->latest()->paginate(10) as $hr)
                                            <tr>
                                                <td>{{ $hr->measured_at }}</td>
                                                <td>{{ $hr->heart_rate }}</td>
                                                <td>{{ $hr->unit->name }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No heart rate records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $profile->heartRates()->latest()->paginate(10)->links() }}
                                </div>
                            </div>

                            <!-- Hydration Tab -->
                            <div class="tab-pane fade" id="hydration" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Unit</th>
                                                <th>Drink At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($profile->hydrationReminders()->latest()->paginate(10) as $hr)
                                            <tr>
                                                <td>{{ $hr->created_at }}</td>
                                                <td>{{ $hr->amount }}</td>
                                                <td>{{ $hr->unit->name }}</td>
                                                <td>{{ $hr->drink_at }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No hydration records found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $profile->hydrationReminders()->latest()->paginate(10)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Initialize tooltips if needed
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
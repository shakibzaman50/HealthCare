@extends('layouts/contentNavbarLayout')

@section('title', 'Create Blood Sugar Record')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create New Blood Sugar Record</h3>
                            <a href="{{ route('bs-records.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('bs-records.store') }}" accept-charset="UTF-8"
                            id="create_bs_record_form" name="create_bs_record_form" class="form-horizontal">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $key => $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="measurement_type_id" class="form-label">Measurement Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('measurement_type_id') is-invalid @enderror" id="measurement_type_id" name="measurement_type_id" required>
                                    <option value="">Select Measurement Type</option>
                                    @foreach ($measurementTypes as $key => $measurementType)
                                        <option value="{{ $measurementType->id }}" {{ old('measurement_type_id') == $measurementType->id ? 'selected' : '' }}>
                                            {{ $measurementType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('measurement_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                                <input class="form-control @error('value') is-invalid @enderror" name="value" type="number" id="value" 
                                    value="{{ old('value') }}" step="any" required>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="recorded_at" class="form-label">Recorded At <span class="text-danger">*</span></label>
                                <input class="form-control @error('recorded_at') is-invalid @enderror" name="recorded_at" type="datetime-local" 
                                    id="recorded_at" value="{{ old('recorded_at') ?? now()->format('Y-m-d\TH:i') }}" required>
                                @error('recorded_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" 
                                    id="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status" type="checkbox" id="status" value="1"
                                        {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
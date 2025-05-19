@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Edit Blood Sugar Record</h3>
                        <div>
                            <a href="{{ route('admin.config.bs_record.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <a href="{{ route('admin.config.bs_record.show', $bsRecord->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ route('admin.config.bs_record.update', $bsRecord->id) }}" accept-charset="UTF-8" id="edit_bs_record_form" name="edit_bs_record_form" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="" style="display: none;" {{ old('user_id', $bsRecord->user_id) == '' ? 'selected' : '' }}>Select User</option>
                                @foreach ($users as $key => $user)
                                    <option value="{{ $key }}" {{ old('user_id', $bsRecord->user_id) == $key ? 'selected' : '' }}>
                                        {{ $user }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="measurement_type_id">Measurement Type</label>
                            <select class="form-control" id="measurement_type_id" name="measurement_type_id" required>
                                <option value="" style="display: none;" {{ old('measurement_type_id', $bsRecord->measurement_type_id) == '' ? 'selected' : '' }}>Select Measurement Type</option>
                                @foreach ($measurementTypes as $key => $measurementType)
                                    <option value="{{ $key }}" {{ old('measurement_type_id', $bsRecord->measurement_type_id) == $key ? 'selected' : '' }}>
                                        {{ $measurementType }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input class="form-control" name="value" type="number" id="value" value="{{ old('value', $bsRecord->value) }}" step="any" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="recorded_at">Recorded At</label>
                            <input class="form-control" name="recorded_at" type="datetime-local" id="recorded_at" 
                                value="{{ old('recorded_at', $bsRecord->recorded_at ? $bsRecord->recorded_at->format('Y-m-d\TH:i') : '') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" name="notes" cols="50" rows="3" id="notes">{{ old('notes', $bsRecord->notes) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" name="status" type="checkbox" id="status" value="1" {{ old('status', $bsRecord->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
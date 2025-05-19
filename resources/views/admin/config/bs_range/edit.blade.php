@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Edit Blood Sugar Range</h3>
                            <div>
                                <a href="{{ route('admin.config.bs_range.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ route('admin.config.bs_range.show', $bsRange->id) }}"
                                    class="btn btn-info btn-sm">
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

                        <form method="POST" action="{{ route('admin.config.bs_range.update', $bsRange->id) }}"
                            accept-charset="UTF-8" id="edit_bs_range_form" name="edit_bs_range_form"
                            class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" type="text" id="name"
                                    value="{{ old('name', $bsRange->name) }}" minlength="1" maxlength="255" required>
                            </div>

                            <div class="form-group">
                                <label for="min_value">Min Value</label>
                                <input class="form-control" name="min_value" type="number" id="min_value"
                                    value="{{ old('min_value', $bsRange->min_value) }}" step="any" required>
                            </div>

                            <div class="form-group">
                                <label for="max_value">Max Value</label>
                                <input class="form-control" name="max_value" type="number" id="max_value"
                                    value="{{ old('max_value', $bsRange->max_value) }}" step="any" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" cols="50" rows="3"
                                    id="description">{{ old('description', $bsRange->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" name="status" type="checkbox" id="status" value="1"
                                        {{ old('status', $bsRange->status) ? 'checked' : '' }}>
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
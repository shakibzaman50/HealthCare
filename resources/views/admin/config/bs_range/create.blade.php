@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create New Blood Sugar Range</h3>
                            <a href="{{ route('admin.config.bs_range.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
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

                        <form method="POST" action="{{ route('admin.config.bs_range.store') }}" accept-charset="UTF-8"
                            id="create_bs_range_form" name="create_bs_range_form" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}"
                                    minlength="1" maxlength="255" required>
                            </div>

                            <div class="form-group">
                                <label for="min_value">Min Value</label>
                                <input class="form-control" name="min_value" type="number" id="min_value"
                                    value="{{ old('min_value') }}" step="any" required>
                            </div>

                            <div class="form-group">
                                <label for="max_value">Max Value</label>
                                <input class="form-control" name="max_value" type="number" id="max_value"
                                    value="{{ old('max_value') }}" step="any" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" cols="50" rows="3"
                                    id="description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" name="status" type="checkbox" id="status" value="1"
                                        checked>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
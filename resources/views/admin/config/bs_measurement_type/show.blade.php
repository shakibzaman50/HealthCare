@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Blood Sugar Measurement Type Details</h3>
                            <div>
                                <a href="{{ route('admin.config.bs_measurement_type.index') }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ route('admin.config.bs_measurement_type.edit', $bsMeasurementType->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST"
                                    action="{{ route('admin.config.bs_measurement_type.destroy', $bsMeasurementType->id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this item?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%">ID</th>
                                        <td>{{ $bsMeasurementType->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $bsMeasurementType->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit</th>
                                        <td>{{ $bsMeasurementType->unit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $bsMeasurementType->description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span
                                                class="badge badge-{{ $bsMeasurementType->status ? 'success' : 'danger' }}">
                                                {{ $bsMeasurementType->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $bsMeasurementType->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $bsMeasurementType->updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
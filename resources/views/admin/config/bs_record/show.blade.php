@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Blood Sugar Record Details</h3>
                            <div>
                                <a href="{{ route('bs-records.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ route('bs-records.edit', $bsRecord->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('bs-records.destroy', $bsRecord->id) }}"
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
                                        <td>{{ $bsRecord->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $bsRecord->user->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $bsRecord->user->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Measurement Type</th>
                                        <td>{{ $bsRecord->measurementType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit</th>
                                        <td>{{ $bsRecord->measurementType->unit ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Value</th>
                                        <td>{{ $bsRecord->value }}</td>
                                    </tr>
                                    <tr>
                                        <th>Recorded At</th>
                                        <td>{{ $bsRecord->recorded_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td>{{ $bsRecord->notes ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-{{ $bsRecord->status ? 'success' : 'danger' }}">
                                                {{ $bsRecord->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $bsRecord->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $bsRecord->updated_at }}</td>
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
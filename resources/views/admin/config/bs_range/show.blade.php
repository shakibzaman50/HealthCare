@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Blood Sugar Range Details</h3>
                        <div>
                            <a href="{{ route('admin.config.bs_range.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <a href="{{ route('admin.config.bs_range.edit', $bsRange->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.config.bs_range.destroy', $bsRange->id) }}" accept-charset="UTF-8" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this item?')">
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
                                    <td>{{ $bsRange->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $bsRange->name }}</td>
                                </tr>
                                <tr>
                                    <th>Min Value</th>
                                    <td>{{ $bsRange->min_value }}</td>
                                </tr>
                                <tr>
                                    <th>Max Value</th>
                                    <td>{{ $bsRange->max_value }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $bsRange->description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $bsRange->status ? 'success' : 'danger' }}">
                                            {{ $bsRange->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $bsRange->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $bsRange->updated_at }}</td>
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
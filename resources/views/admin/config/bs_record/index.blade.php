@extends('layouts/contentNavbarLayout')

@section('title', 'List Blood Sugar Records')

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
                            <h3 class="card-title">Blood Sugar Records</h3>
                            <a href="{{ route('bs-records.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                {!! session('success_message') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Measurement Type</th>
                                        <th>Value</th>
                                        <th>Recorded At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bsRecords as $bsRecord)
                                        <tr>
                                            <td>{{ $bsRecord->id }}</td>
                                            <td>{{ $bsRecord->user->name ?? 'N/A' }}</td>
                                            <td>{{ $bsRecord->measurementType->name ?? 'N/A' }}
                                                ({{ $bsRecord->measurementType->unit ?? '' }})</td>
                                            <td>{{ $bsRecord->value }}</td>
                                            <td>{{ $bsRecord->recorded_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $bsRecord->status ? 'success' : 'danger' }}">
                                                    {{ $bsRecord->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('bs-records.destroy', $bsRecord->id) }}"
                                                    accept-charset="UTF-8">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('bs-records.show', $bsRecord->id) }}"
                                                            class="btn btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('bs-records.edit', $bsRecord->id) }}"
                                                            class="btn btn-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="submit" class="btn btn-danger" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $bsRecords->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
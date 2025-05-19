@extends('layouts/contentNavbarLayout')

@section('title', 'List Blood Sugar Ranges')

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
                            <h3 class="card-title">Blood Sugar Ranges</h3>
                            <a href="{{ route('bs-ranges.create') }}" class="btn btn-primary btn-sm">
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
                                        <th>Name</th>
                                        <th>Min Value</th>
                                        <th>Max Value</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bsRanges as $bsRange)
                                        <tr>
                                            <td>{{ $bsRange->id }}</td>
                                            <td>{{ $bsRange->name }}</td>
                                            <td>{{ $bsRange->min_value }}</td>
                                            <td>{{ $bsRange->max_value }}</td>
                                            <td>
                                                <span class="badge badge-{{ $bsRange->status ? 'success' : 'danger' }}">
                                                    {{ $bsRange->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('bs-ranges.destroy', $bsRange->id) }}"
                                                    accept-charset="UTF-8">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('bs-ranges.show', $bsRange->id) }}"
                                                            class="btn btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('bs-ranges.edit', $bsRange->id) }}"
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
                            {{ $bsRanges->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
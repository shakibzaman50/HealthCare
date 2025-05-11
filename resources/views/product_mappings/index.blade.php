@extends('layouts/layoutMaster')

@section('title', 'Product Mappings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Product Mappings</h4>
                    <a href="{{ route('product-mappings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Mapping
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Internal Product</th>
                                    <th>External Product ID</th>
                                    <th>Source</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mappings as $mapping)
                                <tr>
                                    <td>{{ $mapping->id }}</td>
                                    <td>{{ $mapping->internalProduct->name }}</td>
                                    <td>{{ $mapping->external_product_id }}</td>
                                    <td>{{ $mapping->source }}</td>
                                    <td>
                                        <a href="{{ route('product-mappings.edit', $mapping) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('product-mappings.destroy', $mapping) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this mapping?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $mappings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
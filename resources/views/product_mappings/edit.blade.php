@extends('layouts/layoutMaster')

@section('title', 'Edit Product Mapping')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Product Mapping</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('product-mappings.update', $productMapping) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="internal_product_id" class="form-label">Internal Product</label>
                            <select name="internal_product_id" class="form-select product-select select2" required>
                                @foreach($products as $key=> $product)
                                <option value="{{ $key }}" {{ $productMapping->internal_product_id == $key ? 'selected'
                                    : '' }}>{{ $product }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="external_product_id" class="form-label">External Product ID</label>
                            <input type="text" class="form-control" id="external_product_id" name="external_product_id"
                                value="{{ old('external_product_id', $productMapping->external_product_id) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="external_product_name" class="form-label">Source</label>
                            <input type="text" class="form-control" id="source" name="source"
                                value="{{ old('source', $productMapping->source) }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product-mappings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Mapping
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
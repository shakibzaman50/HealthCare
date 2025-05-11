@extends('layouts/layoutMaster')

@section('title', 'Products List')
@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/select2/select2.js'
])
@endsection

@section('content')
<div class="card-body">
    @can("product-add")
    <div class="col-lg-3 col-md-6">
        @include('products.includes.create')
    </div>
    @endcan
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Cold Storage Quantity</th>
                    <th>Office Quantity</th>
                    <th>Price</th>
                    {{-- <th>Discount</th>
                    <th>Wholesale Price</th> --}}
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td><img src="{{ asset('images/products/thumb/' . $product->image) }}" alt="" width="100px"></td>
                    <td class="cold_storage_quantity">{{ $product->cold_storage_quantity }}</td>
                    <td class="office_quantity">{{ $product->office_quantity }}</td>
                    <td>{{ $product->price }}</td>
                    {{-- <td>{{ $product->discount }}</td>
                    <td>{{ $product->wholesell_price }}</td> --}}
                    <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
                    <td>

                        <div class="btn-group" role="group" aria-label="Role Actions">
                            @can("product-edit")
                            @include('products.includes.edit', ['product' => $product])
                            @endcan
                            <div class="mt-4">
                                <a class="btn btn-success btn-rounded"
                                    href="{{ route('releted.product',$product->id) }}">Releted</a>

                            </div>
                            @can("product-history")
                            <div class="mt-4">
                                <a class="btn btn-info btn-rounded"
                                    href="{{ route('product.stock.history', $product->id) }}">History</a>

                            </div>
                            @endcan

                            @can("product-transfer")
                            <div class="mt-4">
                                <a class="btn btn-info btn-rounded"
                                    href="{{ route('product.transfer.log', $product->id) }}">Transfer Log</a>

                            </div>
                            @endcan
                            @can("product-transfer")
                            <div class="mt-4">
                                <a class="btn btn-success text-black" data-toggle="modal" id="mediumButton"
                                    data-target="#mediumModal" data-attr="{{ route('product.get.stock',$product) }}"
                                    title="View Review"> Transfer
                                </a>
                            </div>
                            @endcan
                            @can("product-delete")
                            @include('products.includes.delete', ['id' => $product->id])
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
{{-- Modal --}}
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body" id="mediumBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('productCreateModal'));
        myModal.show();
    });
</script>
@endif
@endsection
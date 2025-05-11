@extends('layouts/layoutMaster')

@section('title', 'Products List')
@section('vendor-style')
@endsection

@section('vendor-script')

<script>
    $(document).ready(function () {
        const searchInput = $('#searchItem');
        const resultsList = $('#searchResults');
        const relatedProductsTable = $('table tbody');
        const parentProductId = {{ $id }};

        function refreshRelatedProducts() {
            $.ajax({
                url: `/fetch/releted/product/${parentProductId}`,
                method: 'GET',
                success: function (data) {
                    relatedProductsTable.empty();
                    data.forEach(product => {
                        relatedProductsTable.append(`
                            <tr>
                                <td><input type="checkbox" class="delete-checkbox" data-id="${product.id}"></td>
                                <td>${product.id}</td>
                                <td>${product.product.name}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function () {
                    console.error('Error fetching related products');
                }
            });
        }

    // Handle search input
    searchInput.on('input', function () {
        const query = $(this).val();
        if (query.length < 2) {
            resultsList.hide();
            return;
        }

        $.ajax({
            url: '/search-products',
            method: 'GET',
            data: { search: query },
            success: function (data) {
                resultsList.empty().show();
                if (data.length) {
                    data.forEach(product => {
                        resultsList.append(
                            `<li class="list-group-item" data-id="${product.id}">${product.name}</li>`
                        );
                    });
                } else {
                    resultsList.append('<li class="list-group-item text-muted">No products found</li>');
                }
            },
            error: function () {
                console.error('Error fetching products');
            }
        });
    });

    // Handle product click
    resultsList.on('click', 'li', function () {
        Swal.fire('Product Adding into Releted Product');
        const productId = $(this).data('id');
        const parentProductId = {{ $id }}
        $.ajax({
            url: '/store-releted-product',
            method: 'POST',
            data: {
                product_id: productId,
                parent_product_id: parentProductId,
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function (response) {
                Swal.fire(response.message);

                // alert(response.message);
                resultsList.hide();
                searchInput.val(''); // Clear search input
                refreshRelatedProducts();
            },
            error: function () {
                alert('Error saving product');
            }
        });
    });
    $('#deleteSelected').on('click', function () {
            const selectedIds = [];
            $('.delete-checkbox:checked').each(function () {
                selectedIds.push($(this).data('id'));
            });

            if (selectedIds.length === 0) {
                alert('Please select at least one product to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected products?')) {
                $.ajax({
                    url: '/delete-releted-products',
                    method: 'DELETE',
                    data: {
                        ids: selectedIds,
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                    },
                    success: function (response) {
                        Swal.fire(response.message);
                        // alert(response.message);
                        refreshRelatedProducts(); // Refresh the table after deletion
                    },
                    error: function () {
                        alert('Error deleting products');
                    }
                });
            }
        });

        // Select/Deselect all checkboxes
        $('#selectAll').on('change', function () {
            const isChecked = $(this).is(':checked');
            $('.delete-checkbox').prop('checked', isChecked);
        });

        // Individual delete button
        relatedProductsTable.on('click', '.delete-btn', function () {
            const productId = $(this).data('id');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: '/delete-releted-products',
                    method: 'DELETE',
                    data: {
                        ids: [productId],
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                    },
                    success: function (response) {
                        Swal.fire(response.message);

                        // alert(response.message);
                        refreshRelatedProducts(); // Refresh the table after deletion
                    },
                    error: function () {
                        alert('Error deleting product');
                    }
                });
            }
        });

    
});

</script>
@endsection

@section('content')
<div class="card p-2">
    <div class="row">
        <div class="col-md-6">
            <div>
                <input type="text" name="searchItem" class="form-control" placeholder="Search Related Product"
                    id="searchItem">
                <ul id="searchResults" class="list-group mt-2" style="display: none;">
                    <!-- Search results will appear here -->
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reletedProducts as $product)
                        <tr>
                            <td><input type="checkbox" class="delete-checkbox" data-id="{{ $product->id }}"></td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product->name }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $product->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button id="deleteSelected" class="btn btn-danger mt-3">Delete Selected</button>
            </div>
        </div>
    </div>

</div>
@endsection
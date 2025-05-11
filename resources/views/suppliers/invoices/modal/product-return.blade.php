<h4>Product List</h4>
<form action="/invoice/product/list/return" method="POST">
    @csrf
    <input type="hidden" name="invoice_id" value="{{ $invoice_id }}">
    <table class="table table-border">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Return Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product->name }}</td>
                <td>{{ $product->unit_price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->total_price }}</td>
                <td>
                    <input type="number" name="return_quantity[{{$product->product_id}}]" class="form-control">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <input type="text" name="note" class="form-control">
    <button type="submit" class="btn btn-info">Return Product</button>
</form>
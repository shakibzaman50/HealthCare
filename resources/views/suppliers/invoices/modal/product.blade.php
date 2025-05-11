<h5>Invoice Product List</h5>
<table class="table table-border">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
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
        </tr>

        @endforeach
    </tbody>

</table>
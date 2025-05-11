<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Phone</th>
            <th>Name</th>
            <th>Address</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sheets as $sheet)
        <tr>
            <td>{{ $sheet->order_id }}</td>
            <td>{{ $sheet->order->customer->phone }}</td>
            <td>{{ $sheet->order->customer->name }}</td>
            <td>{{ $sheet->order->address }}</td>
            <td>{{ $sheet->order->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
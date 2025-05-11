<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Total</th>
            <th>Last Buying Unit</th>
            <th>Profit</th>

        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->customer->phone }}</td>
            <td> <span
                    class="p-2 text-white rounded {{ $order->status->id == 1? 'bg-primary':($order->status->id == 2? 'bg-info':(($order->status->id == 3? 'bg-warning':($order->status->id == 5? 'bg-dark':($order->status->id == 6? 'bg-danger':'bg-success'))))) }}">{{
                    $order->status->name
                    }}</span></td>
            <td>
                @foreach($order->details as $detail)
                <li>

                    <b> {{ $detail->product->name }}</b> {{ $detail->unit_price }} X {{
                    $detail->quantity }} = {{ $detail->total_price}}
                </li>
                @endforeach

                Total = {{ $order->total }}
            </td>

            <td>
                @php
                $total_buying = 0;
                @endphp
                @foreach($order->details as $detail)
                <li>

                    <b> {{ $detail->product->name }} </b> {{ $detail->product->lastInvoiceProduct->unit_price }} X {{
                    $detail->quantity }} = {{ $detail->product->lastInvoiceProduct->unit_price * $detail->quantity}}
                    @php
                    $total_buying += $detail->product->lastInvoiceProduct->unit_price * $detail->quantity;
                    @endphp

                </li>
                @endforeach
                Total = {{ $total_buying }}
            </td>
            <td>{{ $order->total - $total_buying }}</td>




        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-between">
    <div>
        Showing {{ $orders->count() }} of {{ $orders->total() }} records
    </div>
    <div>
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
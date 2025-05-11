<table class="table">
    <thead>
        <tr>
            <th width="20">
                <input type="checkbox" id="selectAll">
            </th>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Delivery</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Delivery Charge</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
                <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
            </td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->customer->phone }}</td>
            <td> <span
                    class="p-2 text-white rounded {{ $order->status->id == 1? 'bg-primary':($order->status->id == 2? 'bg-info':(($order->status->id == 3? 'bg-warning':($order->status->id == 5? 'bg-dark':($order->status->id == 6? 'bg-danger':'bg-success'))))) }}">{{
                    $order->status->name
                    }}</span></td>
            <td>
                <div class="d-flex align-items-center">
                    {{ $order->delivery->name }}
                    @if($order->courier_synced)
                    <span class="badge bg-success ms-2" title="Synced with courier service">
                        <i class="fas fa-check"></i>
                    </span>
                    @endif
                </div>
            </td>
            </td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->discount }}</td>
            <td>{{ $order->delivery_charge }}</td>
            <td>{{ $order->paid ?? 0}}</td>
            <td>{{ $order->due ?? 0}}</td>
            <td>
                @can("order-change")
                @include('orders.modals.status', ['order' => $order,'statuses'=>$statuses])
                @endcan

                @can("order-payment")

                @include('orders.modals.payment', ['order' => $order])
                @endcan

                @can("order-edit")
                @if($order->status_id == config('status.pending'))
                <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">Edit</a>
                @endif
                @endcan
                @include('orders.modals.invoice', ['order' => $order])
            </td>
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
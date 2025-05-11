<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#sheetShowModal_{{$courier->id}}">
            View
        </button>

        <!-- Modal -->
        <div class="modal fade" id="sheetShowModal_{{$courier->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Courier Sheet # {{$courier->invoice}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sheet ID</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Name</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courier->sheets as $sheet)
                                <tr>
                                    <td>{{ $sheet->id }}</td>
                                    <td>{{ $sheet->order->id }}</td>
                                    <td>{{ $sheet->order->created_at }}</td>
                                    <td>{{ $sheet->order->customer->phone }}</td>
                                    <td>{{ $sheet->order->customer->name }}</td>
                                    <td>{{ $sheet->order->total }}</td>
                                    <td>{{ $sheet->order->paid }}</td>
                                    <td>{{ $sheet->order->due }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
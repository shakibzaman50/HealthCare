<!-- Print Button -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#orderPaymentModal_{{ $order->id }}">
    Payment
</button>

<!-- Large Modal -->
<div class="modal fade" id="orderPaymentModal_{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Show Payment History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if(count($order->payment) > 0)
                <div class="container mx-auto p-4">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Invoice Content -->
                    <table class="table table-stripe">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Paid By</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->payment as $payment)
                            <tr>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->creator->name }}</td>
                                <td>{{ $payment->note }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h5>Sorry No Payment Recorded</h5>
                @endif
                <!-- Print Button in Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</div>
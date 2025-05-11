<!-- Print Button -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#orderInvoiceModal_{{ $order->id }}">
    Invoice
</button>

<!-- Large Modal -->
<div class="modal fade" id="orderInvoiceModal_{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Show Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                    <div class="container" id="invoice_{{ $order->id }}"
                        style="max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif; color: #333;">
                        <div class="row" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                            <div style="width: 45%;">
                                <h3 style="margin: 0;">Mini Arab</h3>
                                <p style="margin: 5px 0;">
                                    C/2 Rain Khola, Mirpur Zoo Road,<br>
                                    Mirpur, Dhaka<br>
                                    Phone: 01236521452<br>
                                    Web: miniarab.com
                                </p>
                            </div>
                            <div style="width: 10%;">
                                {!! QrCode::size(100)->generate( $order->id ); !!}
                            </div>
                            <div style="width: 45%; text-align: right;">
                                <h4 style="margin: 0;">Customer Details</h4>
                                <p style="margin: 5px 0;">
                                    Invoice # {{ $order->id }}<br>
                                    Buyer: {{ $order->customer->name }}<br>
                                    Phone: {{ $order->customer->phone }}<br>
                                    Address: {{ $order->address }}
                                </p>
                            </div>
                        </div>
                        <div class="order-summary" style="margin-bottom: 20px;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #ccc; padding: 8px;">Product Name</th>
                                        <th style="border: 1px solid #ccc; padding: 8px;">Quantity</th>
                                        <th style="border: 1px solid #ccc; padding: 8px;">Price</th>
                                        <th style="border: 1px solid #ccc; padding: 8px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->details as $detail )
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $detail->product->name }}
                                        </td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $detail->quantity }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $detail->unit_price }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $detail->total_price }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="display: flex; justify-content: space-between;">
                            <div style="width: 65%;">
                                @if($order->note)
                                <p style="margin-top: 20px;">Note: {{ $order->note }}</p>
                                @endif
                            </div>
                            <div style="width: 30%;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tbody>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px;">Total</th>
                                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->payable_amount
                                                }}</td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px;">Delivery Charge</th>
                                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->delivery_charge
                                                }}</td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px;">Discount</th>
                                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->discount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px;">Paid</th>
                                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->paid }}</td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid #ccc; padding: 8px;">Due</th>
                                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $order->due }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="footer" style="margin-top: 20px; text-align: center;">
                            <p>Thank you for your purchase! If you have any questions, feel free to contact us.</p>
                        </div>
                    </div>
                </div>

                <!-- Print Button in Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="printInvoice({{ $order->id }})">Print
                        Invoice</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printInvoice(orderId) {
        var invoiceContent = document.getElementById('invoice_' + orderId).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = invoiceContent;

        window.print();

        document.body.innerHTML = originalContent;
        location.reload();  // Reload page to restore content after printing
    }
</script>
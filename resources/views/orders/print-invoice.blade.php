<!DOCTYPE html>
<html>
<head>
    <title>Bulk Invoices</title>
    <style>
        @media print {
            body {
                font-size: 12pt;
                color: #333;
                background-color: #fff;
                font-family: Arial, sans-serif;
            }
            .invoice-container {
                page-break-after: always;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }
            .invoice-container:last-child {
                page-break-after: avoid;
            }
            .header-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .company-info {
                width: 45%;
            }
            .qr-code {
                width: 10%;
                text-align: center;
            }
            .customer-info {
                width: 45%;
                text-align: right;
            }
            .order-summary table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
                margin-bottom: 20px;
            }
            .order-summary th, .order-summary td {
                border: 1px solid #ccc;
                padding: 8px;
            }
            .totals-row {
                display: flex;
                justify-content: space-between;
            }
            .notes {
                width: 65%;
            }
            .totals {
                width: 30%;
            }
            .totals table {
                width: 100%;
                border-collapse: collapse;
            }
            .totals th, .totals td {
                border: 1px solid #ccc;
                padding: 8px;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
            }
            h3, h4 {
                margin: 0;
            }
            p {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    @foreach($orders as $order)
    <div class="invoice-container" id="invoice_{{ $order->id }}">
        <div class="header-row">
            <div class="company-info">
                <h3>Mini Arab</h3>
                <p>
                    C/2 Rain Khola, Mirpur Zoo Road,<br>
                    Mirpur, Dhaka<br>
                    Phone: 01236521452<br>
                    Web: miniarab.com
                </p>
            </div>
            <div class="qr-code">
                {!! QrCode::size(100)->generate($order->id) !!}
            </div>
            <div class="customer-info">
                <h4>Customer Details</h4>
                <p>
                    Invoice # {{ $order->id }}<br>
                    Buyer: {{ $order->customer->name }}<br>
                    Phone: {{ $order->customer->phone }}<br>
                    Address: {{ $order->address }}
                </p>
            </div>
        </div>

        <div class="order-summary">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->unit_price, 2) }}</td>
                        <td>{{ number_format($detail->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-row">
            <div class="notes">
                @if($order->note)
                <p>Note: {{ $order->note }}</p>
                @endif
            </div>
            <div class="totals">
                <table>
                    <tbody>
                        <tr>
                            <th>Total</th>
                            <td>{{ number_format($order->payable_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Delivery Charge</th>
                            <td>{{ number_format($order->delivery_charge, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ number_format($order->discount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Paid</th>
                            <td>{{ number_format($order->paid, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Due</th>
                            <td>{{ number_format($order->due, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your purchase! If you have any questions, feel free to contact us.</p>
        </div>
    </div>
    @endforeach

    <script>
        window.onload = function() {
            if (window.location !== window.parent.location) {
                document.body.style.margin = '0';
                document.body.style.padding = '0';
                window.print();
            }
        };
    </script>
</body>
</html> 
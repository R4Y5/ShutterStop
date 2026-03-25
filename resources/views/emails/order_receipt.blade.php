<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        /* Neo-Brutalist Base */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #ffffff;
            background-image: linear-gradient(#d0d0d0 1px, transparent 1px), linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
            background-size: 50px 50px;
            margin: 0;
            padding: 40px 20px;
        }

        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border: 4px solid #000;
            box-shadow: 12px 12px 0px 0px #000;
            overflow: hidden;
        }

        /* Header */
        .receipt-header {
            background: #000;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .receipt-header h2 {
            font-family: 'Inter', Arial, sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin: 0;
            color: #ffff00;
        }

        .receipt-header .order-tag {
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #aaa;
        }

        /* Body */
        .receipt-body {
            padding: 30px;
        }

        .greeting {
            font-weight: 900;
            font-size: 1rem;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #000;
        }

        .subtext {
            font-size: 0.85rem;
            font-weight: bold;
            color: #444;
            margin-bottom: 24px;
            text-transform: uppercase;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            margin-bottom: 20px;
        }

        thead th {
            background: #000;
            color: #fff;
            text-transform: uppercase;
            padding: 12px 14px;
            font-weight: 900;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-align: left;
        }

        tbody td {
            padding: 11px 14px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            font-size: 0.9rem;
            color: #000;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #fffde7;
        }

        /* Total block */
        .total-block {
            background: #ffff00;
            border: 3px solid #000;
            box-shadow: 5px 5px 0px #000;
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .total-block .total-label {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .total-block .total-amount {
            font-weight: 900;
            font-size: 1.2rem;
        }

        /* Meta info */
        .order-meta {
            border: 3px solid #000;
            padding: 12px 16px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            box-shadow: 4px 4px 0px #000;
            margin-bottom: 24px;
        }

        .order-meta span {
            color: #555;
        }

        /* Footer */
        .receipt-footer {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 14px 20px;
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">

        <div class="receipt-header">
            <h2>Order Receipt</h2>
            <span class="order-tag">ShutterStop</span>
        </div>

        <div class="receipt-body">
            <p class="greeting">Hello, {{ $order->first_name }}!</p>
            <p class="subtext">Thank you for your purchase. Here are your order details:</p>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-block">
                <span class="total-label">Total Amount</span>
                <span class="total-amount">₱{{ number_format($order->total, 2) }}</span>
            </div>

            <div class="order-meta">
                Order Date: <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            &copy; {{ date('Y') }} ShutterStop. All rights reserved.
        </div>

    </div>
</body>
</html>
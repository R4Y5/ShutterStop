<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .receipt-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border: 1px solid #ddd; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h2>Order Receipt</h2>
        <p>Hello {{ $order->first_name }},</p>
        <p>Thank you for your purchase! Here are your order details:</p>

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

        <p class="total">Total: ₱{{ number_format($order->total, 2) }}</p>
        <p>Order Date: {{ $order->created_at->format('M d, Y h:i A') }}</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} ShutterStop. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

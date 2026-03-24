<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Updated</title>
</head>
<body>
    <h2>Hello {{ $order->first_name }},</h2>
    <p>Your order #{{ $order->id }} status has been updated to 
       <strong>{{ $order->status }}</strong>.</p>
    <p>A PDF receipt is attached for your records.</p>
    <p>Thank you for shopping with ShutterStop!</p>
</body>
</html>
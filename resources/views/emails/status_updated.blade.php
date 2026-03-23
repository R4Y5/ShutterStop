<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Updated</title>
</head>
<body>
    <h2>Hello {{ $order->user->first_name }},</h2>

    <p>Your order #{{ $order->id }} status has been updated to: <strong>{{ $order->status }}</strong>.</p>

    <p>We’ve attached your updated receipt in PDF format for your records.</p>

    <p>Thank you for shopping with us!</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Purchased</title>
</head>
<body>
    <h2>Thank you for your order!</h2>
  <p>Order #{{ $order->id }}</p>
  <p>Status: {{ $order->status }}</p>
  <p>Total: ₱{{ number_format($order->total, 2) }}</p>

  <h4>Items:</h4>
  <ul>
  @foreach($order->items as $item)
      <li>{{ $item->product->name }} (x{{ $item->quantity }}) - ₱{{ number_format($item->price, 2) }}</li>
  @endforeach
  </ul>
</body>
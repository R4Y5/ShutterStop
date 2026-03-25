<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Updated</title>
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

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border: 4px solid #000;
            box-shadow: 12px 12px 0px 0px #000;
            overflow: hidden;
        }

        /* Header */
        .email-header {
            background: #000;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .email-header h2 {
            font-family: 'Inter', Arial, sans-serif;
            font-weight: 900;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin: 0;
            color: #ffff00;
        }

        .email-header .brand-tag {
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #aaa;
        }

        /* Body */
        .email-body {
            padding: 30px;
        }

        .greeting {
            font-weight: 900;
            font-size: 1rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #000;
        }

        /* Status block */
        .status-block {
            background: #ffff00;
            border: 3px solid #000;
            box-shadow: 5px 5px 0px #000;
            padding: 14px 18px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .status-block .status-label {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            color: #000;
        }

        .status-block .status-value {
            font-weight: 900;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
            border: 2px solid #000;
            padding: 4px 12px;
            background: #fff;
        }

        /* Info block */
        .info-block {
            border: 3px solid #000;
            padding: 14px 18px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            box-shadow: 4px 4px 0px #000;
            margin-bottom: 24px;
            line-height: 1.7;
        }

        /* Footer */
        .email-footer {
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
    <div class="email-container">

        <div class="email-header">
            <h2>Order Status Updated</h2>
            <span class="brand-tag">ShutterStop</span>
        </div>

        <div class="email-body">
            <p class="greeting">Hello, {{ $order->first_name }}!</p>

            <div class="status-block">
                <span class="status-label">Order #{{ $order->id }} — New Status</span>
                <span class="status-value">{{ $order->status }}</span>
            </div>

            <div class="info-block">
                A PDF receipt has been attached for your records.<br>
                Thank you for shopping with ShutterStop!
            </div>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} ShutterStop. All rights reserved.
        </div>

    </div>
</body>
</html>
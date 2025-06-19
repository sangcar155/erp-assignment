<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Order PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>🧾 Sales Order #{{ $order->id }}</h2>

    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
    <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->sku }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>₹{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

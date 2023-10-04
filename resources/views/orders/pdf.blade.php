<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
<h1>Order Details</h1>
<p>Order ID: {{ $order->id }}</p>
<p>Customer Name: {{ $order->user->name }}</p>
<!-- Add more order details here -->
</body>
</html>


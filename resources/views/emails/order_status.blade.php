<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Order Status</title>
<style>
body { font-family: Arial, sans-serif; background: #f4f4f4; margin:0; padding:0; }
.container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
h2 { color: #333; }
p { margin: 5px 0; }
.button { display: inline-block; padding: 10px 20px; margin: 10px 5px 0 0; border-radius: 5px; text-decoration: none; color: white; }
.approve { background: #28a745; }
.reject { background: #dc3545; }
</style>
</head>
<body>
<div class="container">
    <h2>Order Status Update</h2>
    <p>Hello {{ $order->purchaseRequest->requester->name }},</p>
    <p>Your order <strong>{{ $order->reference }}</strong> from request <strong>{{ $order->purchaseRequest->reference }}</strong> is <strong>{{ ucfirst($order->status) }}</strong>.</p>

    @if($order->status === 'sent')
        <p>You can approve or reject this order:</p>
        <a href="{{ route('orders.approve', $order->uuid) }}" class="button approve">Approve</a>
        <a href="{{ route('orders.reject', $order->uuid) }}" class="button reject">Reject</a>
    @endif
</div>
</body>
</html>

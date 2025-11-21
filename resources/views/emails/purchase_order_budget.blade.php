<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Purchase Order</title>
<style>
body { font-family: Arial, sans-serif; background: #f4f4f4; margin:0; padding:0; }
.container { max-width: 700px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
h2, h3, h4 { color: #333; }
p { margin: 5px 0; }
.button { display: inline-block; padding: 10px 20px; margin: 10px 5px 0 0; border-radius: 5px; text-decoration: none; color: white; }
.confirm { background: #28a745; }
.reject { background: #dc3545; }
.table { width: 100%; border-collapse: collapse; margin-top: 15px; }
.table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
</style>
</head>
<body>
<div class="container">
    <h3>Purchase Order: {{ $order->reference ?? 'N/A' }}</h3>
    <p>Date: {{ $order->date ?? 'N/A' }}</p>
    <p>Total Items: {{ $order->total_item ?? 0 }}</p>
    <p>Total Quantity: {{ $order->total_quantity ?? 0 }}</p>
    <p>Total Amount: {{ $order->total_amount ?? 0 }}</p>

    <h4>Purchase Request Details</h4>
    <p>Reference: {{ $order->purchaseRequest?->reference ?? 'N/A' }}</p>
    <p>Status: {{ $order->purchaseRequest?->status ?? 'N/A' }}</p>
    <p>Date: {{ $order->purchaseRequest?->date ?? 'N/A' }}</p>
    <p>Total Items: {{ $order->purchaseRequest?->total_item ?? 0 }}</p>
    <p>Total Quantity: {{ $order->purchaseRequest?->total_quantity ?? 0 }}</p>
    <p>Total Amount: {{ $order->purchaseRequest?->total_amount ?? 0 }}</p>
    {{-- <p>Remarks: {{ $order->purchaseRequest?->remarks ?? '-' }}</p> --}}
    <p>Requester: {{ $order->purchaseRequest?->requester?->name." ". $order->purchaseRequest?->requester?->last_name ?? 'N/A' }}</p>
    <p>Budget Officer: {{ $order->purchaseRequest?->budgetOfficer?->name." ". $order->purchaseRequest?->budgetOfficer?->last_name ?? 'N/A' }}</p>

    <h4>Requests Items Details By Supplier</h4>
    @foreach($order->purchaseRequest?->requests ?? [] as $req)
        <h4>Supplier: {{ $req->supplier?->name ?? 'N/A' }} {{ $req->supplier?->last_name ?? '' }}</h4>
        <p>Request Reference: {{ $req->reference ?? 'N/A' }}</p>
        <p>Status: {{ $req->status ?? 'N/A' }}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($req->items ?? [] as $item)
                <tr>
                    <td>{{ $item->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity ?? 0 }}</td>
                    <td>{{ $item->unit_price ?? 0 }}</td>
                    <td>{{ $item->subtotal ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <p>You can confirm or reject this order:</p>
    <a href="{{ route('orders.approve', $order->uuid) }}" class="button confirm">Confirm</a>
    <a href="{{ route('orders.reject', $order->uuid) }}" class="button reject">Reject</a>
</div>
</body>
</html>

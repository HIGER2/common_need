<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Purchase Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0; padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2, h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px 0;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-approve {
            background-color: #28a745;
        }
        .btn-reject {
            background-color: #dc3545;
        }
        .section {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        @media (max-width: 600px) {
            .grid {
                display: block;
            }
            table, th, td {
                font-size: 14px;
            }
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Purchase Request Details</h2>

        <!-- Global Info -->
        <div class="section">
            <h3>Global Purchase Info</h3>
            <div class="grid">
                <p><strong>Reference:</strong> {{ $request->reference }}</p>
                <p><strong>Date:</strong> {{ $request->date }}</p>
                <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
                <p><strong>Total Items:</strong> {{ $request->total_item }}</p>
                <p><strong>Total Quantity:</strong> {{ $request->total_quantity }}</p>
                <p><strong>Total Amount:</strong> {{ number_format($request->total_amount,2,',',' ') }} FCFA</p>
            </div>
        </div>

        <!-- Requester Info -->
        <div class="section">
            <h3>Requester Info</h3>
            <p><strong>Name:</strong> {{ $request->requester->name }}</p>
            <p><strong>Email:</strong> {{ $request->requester->email }}</p>
            {{-- <p><strong>Role:</strong> {{ $request->requester->role }}</p> --}}
        </div>
        <h4>Requests Items Details By Supplier</h4>
        <!-- Supplier Requests -->
        @foreach($request->requests as $req)
        <div class="section">
            <h3>Supplier: {{ $req->supplier->name }}</h3>
            <p><strong>Reference:</strong> {{ $req->reference }}</p>
            <p><strong>Status:</strong> {{ ucfirst($req->status) }}</p>
            <p><strong>Total Items:</strong> {{ $req->total_item }}</p>
            <p><strong>Total Quantity:</strong> {{ $req->total_quantity }}</p>
            <p><strong>Total Amount:</strong> {{ number_format($req->total_amount,2,',',' ') }} FCFA</p>

            <h4>Items</h4>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($req->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price,2,',',' ') }} FCFA</td>
                        <td>{{ number_format($item->subtotal,2,',',' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        <!-- Action Buttons -->
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ url('/requests/approve/'.$request->uuid) }}" class="btn btn-approve">Approve</a>
            <a href="{{ url('/requests/reject/'.$request->uuid) }}" class="btn btn-reject">Reject</a>
        </div>
    </div>
</body>
</html>

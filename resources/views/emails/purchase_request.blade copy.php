<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Purchase Request</title>
</head>

<body style="margin:0; padding:0; background:#f5f6fa; font-family:Arial, sans-serif;">

    <div style="max-width:600px; margin:20px auto; background:#ffffff; border-radius:8px; padding:20px; border:1px solid #eee;">

        <!-- Titre principal -->
        <h2 style="color:#2c3e50; margin-bottom:10px; text-align:center;">
            Purchase Request Summary
        </h2>

        <!-- Global Info -->
        <h3 style="color:#34495e; border-bottom:1px solid #ddd; padding-bottom:5px;">Global Information</h3>

        <p><strong>Reference:</strong> {{ $request->reference }}</p>
        <p><strong>Date:</strong> {{ $request->date }}</p>
        <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
        <p><strong>Total Items:</strong> {{ $request->total_item }}</p>
        <p><strong>Total Quantity:</strong> {{ $request->total_quantity }}</p>
        <p><strong>Total Amount:</strong>
            {{ number_format($request->total_amount,2,',',' ') }} FCFA
        </p>


        <!-- Requester Info -->
        <h3 style="color:#34495e; border-bottom:1px solid #ddd; padding-bottom:5px; margin-top:25px;">
            Requester Information
        </h3>

        <p><strong>Name:</strong> {{ $request->requester->name }}</p>
        <p><strong>Email:</strong> {{ $request->requester->email }}</p>


        <!-- Supplier sections -->
        <h3 style="color:#34495e; margin-top:25px;">Details by Supplier</h3>

        @foreach($request->requests as $req)
        <div style="margin:20px 0; padding:15px; border:1px solid #e1e1e1; border-radius:6px;">

            <h4 style="color:#2c3e50; margin:0 0 10px 0;">
                Supplier: {{ $req->supplier->name }}
            </h4>

            <p><strong>Reference:</strong> {{ $req->reference }}</p>
            <p><strong>Status:</strong> {{ ucfirst($req->status) }}</p>
            <p><strong>Total Items:</strong> {{ $req->total_item }}</p>
            <p><strong>Total Quantity:</strong> {{ $req->total_quantity }}</p>
            <p><strong>Total Amount:</strong>
                {{ number_format($req->total_amount,2,',',' ') }} FCFA
            </p>

            <!-- Items table -->
            <table width="100%" cellpadding="6" cellspacing="0"
                style="border-collapse:collapse; font-size:14px; margin-top:10px;">

                <thead>
                    <tr style="background:#f0f0f0;">
                        <th align="left" style="border:1px solid #ddd;">Product</th>
                        <th align="center" style="border:1px solid #ddd;">Qty</th>
                        <th align="right" style="border:1px solid #ddd;">Unit Price</th>
                        <th align="right" style="border:1px solid #ddd;">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($req->items as $item)
                    <tr>
                        <td style="border:1px solid #ddd;">{{ $item->name }}</td>
                        <td align="center" style="border:1px solid #ddd;">{{ $item->quantity }}</td>
                        <td align="right" style="border:1px solid #ddd;">
                            {{ number_format($item->unit_price,2,',',' ') }} FCFA
                        </td>
                        <td align="right" style="border:1px solid #ddd;">
                            {{ number_format($item->subtotal,2,',',' ') }} FCFA
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        @endforeach


        <!-- Buttons -->
        <div style="text-align:center; margin-top:30px;">
            <a href="{{ url('/requests/approve/'.$request->uuid) }}"
                style="padding:12px 20px; background:#28a745; color:#fff; 
                text-decoration:none; border-radius:5px; font-weight:bold;">
                Approve
            </a>

            <a href="{{ url('/requests/reject/'.$request->uuid) }}"
                style="padding:12px 20px; background:#dc3545; color:#fff; 
                text-decoration:none; border-radius:5px; font-weight:bold; margin-left:10px;">
                Reject
            </a>
        </div>

    </div>

</body>

</html>
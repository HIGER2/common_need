<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Purchase Request Status</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin:0; padding:0; }
    .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
    h2 { color: #333; }
    p { margin: 5px 0; }
    .status { font-weight: bold; }
</style>
</head>
<body>
<div class="container">
    <h2>Purchase Request Status Update</h2>
    <p>Hello {{ $request->requester->name }},</p>
    <p>Your purchase request <strong>{{ $request->reference }}</strong> has been <span class="status">{{ ucfirst($request->status) }}</span>.</p>
    <p>Thank you!</p>
</div>
</body>
</html>

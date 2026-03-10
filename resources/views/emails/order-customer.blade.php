<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Order Confirmed – MariaBakes</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f4f0eb;margin:0;padding:40px 20px;color:#3d1f0f;}
    .wrap{max-width:600px;margin:0 auto;}
    .header{background:linear-gradient(135deg,#f9b8c4,#e8849a);border-radius:16px 16px 0 0;padding:40px;text-align:center;}
    .logo-circle{width:64px;height:64px;background:white;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:28px;}
    .brand{color:#3d1f0f;font-size:28px;font-weight:900;letter-spacing:2px;font-family:Georgia,serif;}
    .sub-brand{color:rgba(61,31,15,.5);font-size:12px;letter-spacing:2px;text-transform:uppercase;margin-top:4px;}
    .body{background:white;border-radius:0 0 16px 16px;padding:36px;border:1px solid rgba(0,0,0,.06);border-top:none;}
    .greeting{font-family:Georgia,serif;font-size:22px;color:#3d1f0f;margin-bottom:8px;}
    .msg{font-size:15px;color:rgba(61,31,15,.6);line-height:1.75;margin-bottom:28px;}
    .order-box{background:#fff8f0;border-radius:14px;padding:20px;margin-bottom:24px;}
    .order-num{font-family:Georgia,serif;font-size:20px;color:#c45c7a;font-weight:900;margin-bottom:4px;}
    .field{margin-bottom:8px;display:flex;gap:8px;}
    .flbl{font-size:12px;font-weight:900;color:rgba(61,31,15,.4);min-width:100px;}
    .fval{font-size:14px;font-weight:600;color:#3d1f0f;}
    .section-title{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.12em;color:rgba(61,31,15,.4);margin:20px 0 10px;}
    table{width:100%;border-collapse:collapse;}
    th{background:#f4f0eb;padding:8px 12px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);}
    td{padding:10px 12px;border-bottom:1px solid #f4f0eb;font-size:14px;}
    .total-row td{font-weight:900;font-size:16px;border-bottom:none;}
    .info-box{background:rgba(249,184,196,.2);border-radius:12px;padding:16px;font-size:14px;color:#3d1f0f;line-height:1.7;margin-top:20px;}
    .footer{text-align:center;margin-top:24px;color:rgba(61,31,15,.35);font-size:12px;line-height:1.8;}
  </style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo-circle">🍪</div>
    <div class="brand">MariaBakes</div>
    <div class="sub-brand">Homemade by Ching</div>
  </div>
  <div class="body">
    <p class="greeting">Hi {{ $order->first_name }}! 🎉</p>
    <p class="msg">Thank you for ordering from MariaBakes! We've received your order and will reach out soon to confirm the details and payment. We can't wait to bake for you! 🍫</p>

    <div class="order-box">
      <div class="order-num">{{ $order->order_number }}</div>
      <div style="font-size:13px;color:rgba(61,31,15,.4);margin-bottom:16px;">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
      <div class="field"><span class="flbl">Type</span><span class="fval">{{ ucfirst($order->order_type) }}</span></div>
      @if($order->address)<div class="field"><span class="flbl">Address</span><span class="fval">{{ $order->address }}</span></div>@endif
      @if($order->delivery_app)<div class="field"><span class="flbl">Via</span><span class="fval">{{ $order->delivery_app }}</span></div>@endif
      <div class="field"><span class="flbl">Date</span><span class="fval">{{ $order->preferred_date }}</span></div>
      <div class="field"><span class="flbl">Time</span><span class="fval">{{ $order->preferred_time }}</span></div>
    </div>

    <div class="section-title">Your Order</div>
    <table>
      <thead><tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr></thead>
      <tbody>
        @foreach($order->items as $item)
        <tr><td>{{ $item->product_name }}</td><td>×{{ $item->quantity }}</td><td>₱{{ number_format($item->subtotal,0) }}</td></tr>
        @endforeach
        <tr class="total-row"><td colspan="2" style="text-align:right">Total</td><td style="color:#c45c7a">₱{{ number_format($order->total,0) }}</td></tr>
      </tbody>
    </table>

    <div class="info-box">
      💳 <strong>Payment:</strong> GCash or Cash on Pickup/Delivery<br>
      📩 <strong>Questions?</strong> Just reply to this email or message us on Facebook/Instagram.<br>
      ⏰ <strong>Note:</strong> We'll contact you to confirm your order details.
    </div>
  </div>
  <div class="footer">
    MariaBakes – Homemade by Ching · Dasmarinas, Cavite<br>
    © {{ date('Y') }} MariaBakes. Made with 🍪 and love.
  </div>
</div>
</body>
</html>
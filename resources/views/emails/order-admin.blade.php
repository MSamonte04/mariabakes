<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>New Order – MariaBakes</title>
  <style>
    body{font-family:Arial,sans-serif;background:#f4f0eb;margin:0;padding:40px 20px;color:#3d1f0f;}
    .wrap{max-width:600px;margin:0 auto;}
    .header{background:linear-gradient(135deg,#3d1f0f,#7a3e1e);border-radius:16px 16px 0 0;padding:40px;text-align:center;}
    .logo-circle{width:64px;height:64px;background:#f9b8c4;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;font-size:28px;}
    .brand{color:#f9b8c4;font-size:28px;font-weight:900;letter-spacing:2px;font-family:Georgia,serif;}
    .sub-brand{color:rgba(255,255,255,.5);font-size:12px;letter-spacing:2px;text-transform:uppercase;margin-top:4px;}
    .badge{display:inline-block;background:#c45c7a;color:white;font-size:12px;font-weight:900;letter-spacing:1px;text-transform:uppercase;padding:6px 16px;border-radius:100px;margin-top:16px;}
    .body{background:white;border-radius:0 0 16px 16px;padding:36px;border:1px solid rgba(0,0,0,.06);border-top:none;}
    .order-num{font-size:24px;font-weight:900;color:#c45c7a;margin-bottom:4px;font-family:Georgia,serif;}
    .date{color:rgba(61,31,15,.45);font-size:13px;margin-bottom:28px;}
    .section-title{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.12em;color:rgba(61,31,15,.4);margin-bottom:12px;border-bottom:1px solid #f4f0eb;padding-bottom:6px;}
    .field{margin-bottom:10px;display:flex;gap:8px;}
    .flbl{font-size:12px;font-weight:900;color:rgba(61,31,15,.4);min-width:120px;}
    .fval{font-size:14px;font-weight:600;color:#3d1f0f;}
    table{width:100%;border-collapse:collapse;margin-top:12px;}
    th{background:#f4f0eb;padding:8px 12px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);}
    td{padding:10px 12px;border-bottom:1px solid #f4f0eb;font-size:14px;color:#3d1f0f;}
    .total-row td{font-weight:900;font-size:16px;border-bottom:none;background:#fff8f0;}
    .cta{text-align:center;margin-top:24px;}
    .cta a{background:#3d1f0f;color:white;text-decoration:none;font-weight:900;font-size:14px;padding:14px 32px;border-radius:100px;display:inline-block;}
    .footer{text-align:center;margin-top:24px;color:rgba(61,31,15,.35);font-size:12px;line-height:1.8;}
    .notes-box{background:#fff8f0;border-radius:10px;padding:12px 16px;font-size:14px;color:rgba(61,31,15,.7);line-height:1.6;margin-top:8px;}
  </style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo-circle">🍪</div>
    <div class="brand">MariaBakes</div>
    <div class="sub-brand">Homemade by Ching</div>
    <div class="badge">🍪 New Order Received!</div>
  </div>
  <div class="body">
    <div class="order-num">{{ $order->order_number }}</div>
    <div class="date">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>

    <div class="section-title">Customer Details</div>
    <div class="field"><span class="flbl">Name</span><span class="fval">{{ $order->full_name }}</span></div>
    <div class="field"><span class="flbl">Email</span><span class="fval">{{ $order->email }}</span></div>
    <div class="field"><span class="flbl">Phone</span><span class="fval">{{ $order->phone }}</span></div>

    <div class="section-title" style="margin-top:20px">Delivery Details</div>
    <div class="field"><span class="flbl">Order Type</span><span class="fval">{{ ucfirst($order->order_type) }}</span></div>
    @if($order->address)<div class="field"><span class="flbl">Address</span><span class="fval">{{ $order->address }}</span></div>@endif
    @if($order->delivery_app)<div class="field"><span class="flbl">Delivery App</span><span class="fval">{{ $order->delivery_app }}</span></div>@endif
    <div class="field"><span class="flbl">Date</span><span class="fval">{{ $order->preferred_date }}</span></div>
    <div class="field"><span class="flbl">Time</span><span class="fval">{{ $order->preferred_time }}</span></div>
    @if($order->notes)
    <div style="margin-top:8px"><span class="flbl">Notes</span><div class="notes-box">{{ $order->notes }}</div></div>
    @endif

    <div class="section-title" style="margin-top:20px">Order Items</div>
    <table>
      <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
      <tbody>
        @foreach($order->items as $item)
        <tr><td>{{ $item->product_name }}</td><td>₱{{ number_format($item->product_price,0) }}</td><td>×{{ $item->quantity }}</td><td>₱{{ number_format($item->subtotal,0) }}</td></tr>
        @endforeach
        <tr class="total-row"><td colspan="3" style="text-align:right;font-size:14px">Total</td><td style="color:#c45c7a">₱{{ number_format($order->total,0) }}</td></tr>
      </tbody>
    </table>

    <div class="cta">
      <a href="{{ url('/admin/orders/' . $order->id) }}">View in Admin Panel →</a>
    </div>
  </div>
  <div class="footer">
    MariaBakes – Homemade by Ching · Dasmarinas, Cavite<br>
    © {{ date('Y') }} MariaBakes. This is an automated notification.
  </div>
</div>
</body>
</html>
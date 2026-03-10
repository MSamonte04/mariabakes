<!DOCTYPE html>
<html><head><meta charset="UTF-8"/><title>New Order</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;padding:40px 20px;color:#1a1a1a}
.wrap{max-width:600px;margin:0 auto}
.header{background:linear-gradient(135deg,#3d1f0f,#7a3e1e);border-radius:16px 16px 0 0;padding:40px;text-align:center}
.logo{font-family:Georgia,serif;font-size:32px;color:white}.logo span{color:#f9b8c4}
.badge{display:inline-block;background:#c45c7a;color:white;font-size:12px;font-weight:900;letter-spacing:1px;text-transform:uppercase;padding:6px 16px;border-radius:100px;margin-top:16px}
.body{background:white;border-radius:0 0 16px 16px;padding:40px;border:1px solid rgba(0,0,0,.06);border-top:none}
.title{font-size:22px;font-weight:900;color:#3d1f0f;margin-bottom:6px}
.subtitle{color:rgba(0,0,0,.45);font-size:14px;margin-bottom:28px}
.field{margin-bottom:14px}.label{font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.12em;color:rgba(0,0,0,.4);margin-bottom:4px}
.value{background:#fff8f0;border:1px solid rgba(0,0,0,.07);border-radius:10px;padding:12px 16px;font-size:15px;color:#1a1a1a;font-weight:600}
.items-table{width:100%;border-collapse:collapse;margin:16px 0}
.items-table th{text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;color:rgba(0,0,0,.4);padding:8px 0;border-bottom:2px solid #fff8f0}
.items-table td{padding:10px 0;border-bottom:1px solid #fff8f0;font-size:14px;font-weight:600}
.total-row{display:flex;justify-content:space-between;padding:12px 0;font-weight:900;font-size:18px;color:#3d1f0f;border-top:2px solid #fff8f0}
.divider{height:1px;background:rgba(0,0,0,.06);margin:24px 0}
.cta{text-align:center;margin-top:24px}
.cta a{background:#3d1f0f;color:white;text-decoration:none;font-weight:900;font-size:15px;padding:14px 36px;border-radius:100px;display:inline-block}
.footer{text-align:center;margin-top:24px;color:rgba(0,0,0,.35);font-size:12px;line-height:1.8}
</style></head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo"><span>Maria</span>Bakes</div>
    <div style="color:rgba(255,255,255,.6);font-size:13px;margin-top:4px">Homemade by Ching</div>
    <div class="badge">🍪 New Order #{{ $order->id }}</div>
  </div>
  <div class="body">
    <div class="title">New Order Received!</div>
    <div class="subtitle">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
      <div class="field"><div class="label">Customer</div><div class="value">{{ $order->full_name }}</div></div>
      <div class="field"><div class="label">Phone</div><div class="value">{{ $order->phone }}</div></div>
      <div class="field"><div class="label">Email</div><div class="value" style="font-size:13px">{{ $order->email }}</div></div>
      <div class="field"><div class="label">Order Type</div><div class="value">{{ $order->order_type === 'delivery' ? '🚚 Delivery' : '🏠 Pickup' }}</div></div>
      @if($order->order_type === 'delivery')
      <div class="field" style="grid-column:span 2"><div class="label">Delivery Address</div><div class="value">{{ $order->address }}</div></div>
      <div class="field"><div class="label">Delivery App</div><div class="value">{{ $order->delivery_app }}</div></div>
      @endif
    </div>
    @if($order->notes)
    <div class="field"><div class="label">Special Notes</div><div class="value">{{ $order->notes }}</div></div>
    @endif
    <div class="divider"></div>
    <div class="label" style="margin-bottom:8px">Items Ordered</div>
    <table class="items-table">
      <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item['emoji'] ?? '🍪' }} {{ $item['name'] }}</td>
          <td>×{{ $item['qty'] }}</td>
          <td>₱{{ number_format($item['price'],0) }}</td>
          <td>₱{{ number_format($item['price'] * $item['qty'],0) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="total-row"><span>Total</span><span>₱{{ number_format($order->total,2) }}</span></div>
    <div class="cta"><a href="{{ route('admin.show',$order) }}">View in Admin Panel →</a></div>
  </div>
  <div class="footer">
    This email was sent automatically by MariaBakes website.<br>
    © {{ date('Y') }} MariaBakes – Homemade by Ching · Dasmarinas, Cavite
  </div>
</div>
</body></html>
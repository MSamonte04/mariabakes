<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Order #{{ $order->id }} – MariaBakes Admin</title>
  @vite(['resources/css/app.css'])
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{cursor:default!important}a,button,select{cursor:pointer!important}input,textarea{cursor:text!important}
    body{font-family:'Nunito',sans-serif;background:#fff8f0;color:#3d1f0f;min-height:100vh}
    .admin-nav{background:#3d1f0f;padding:16px 32px;display:flex;align-items:center;justify-content:space-between}
    .admin-nav-logo{font-family:'Playfair Display',serif;font-size:20px;color:white}.admin-nav-logo span{color:#f9b8c4}
    .admin-nav a{color:rgba(255,255,255,.6);font-size:14px;font-weight:700;text-decoration:none;transition:color .2s}.admin-nav a:hover{color:white}
    .admin-wrap{max-width:800px;margin:0 auto;padding:40px 32px}
    .card{background:white;border-radius:20px;overflow:hidden;border:1px solid rgba(61,31,15,.06);margin-bottom:20px}
    .card-head{background:#3d1f0f;padding:24px 32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .card-title{font-family:'Playfair Display',serif;font-size:24px;color:white}
    .card-sub{font-size:13px;color:rgba(255,255,255,.5);margin-top:4px}
    .card-body{padding:32px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
    .detail-field{background:#fff8f0;border-radius:12px;padding:16px 20px}
    .detail-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);margin-bottom:6px}
    .detail-value{font-size:15px;font-weight:700;color:#3d1f0f}
    .items-table{width:100%;border-collapse:collapse;margin-bottom:16px}
    .items-table th{text-align:left;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);padding:8px 0;border-bottom:2px solid #fdeee0}
    .items-table td{padding:10px 0;border-bottom:1px solid #fdeee0;font-size:14px;font-weight:600;color:#3d1f0f}
    .items-total{display:flex;justify-content:space-between;padding:12px 0;font-weight:900;font-size:18px;color:#3d1f0f;border-top:2px solid #fdeee0;margin-top:4px}
    .status-badge{display:inline-block;padding:6px 16px;border-radius:100px;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}
    .form-group{margin-bottom:16px}
    .form-label{display:block;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.5);margin-bottom:6px}
    .form-select{background:#fff8f0;border:2px solid rgba(61,31,15,.12);border-radius:10px;padding:10px 14px;font-family:'Nunito',sans-serif;font-size:14px;color:#3d1f0f;outline:none}
    .form-select:focus{border-color:#e8849a}
    .btn{padding:12px 24px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:800;font-size:14px;cursor:pointer;transition:all .2s;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:8px}
    .btn-primary{background:#3d1f0f;color:white}.btn-primary:hover{background:#7a3e1e}
    .btn-outline{background:transparent;border:2px solid #3d1f0f;color:#3d1f0f}.btn-outline:hover{background:#3d1f0f;color:white}
    .btn-reply{background:#fff0f5;color:#c45c7a;border:2px solid #f9b8c4}.btn-reply:hover{background:#c45c7a;color:white;border-color:#c45c7a}
    .btn-delete{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}.btn-delete:hover{background:#dc2626;color:white}
    .flash{background:#dcfce7;border:1px solid #86efac;color:#166534;border-radius:12px;padding:12px 20px;margin-bottom:20px;font-weight:700;font-size:14px}
    .action-row{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
  </style>
</head>
<body>
<nav class="admin-nav">
  <div class="admin-nav-logo"><span>Maria</span>Bakes Admin</div>
  <a href="{{ route('admin.dashboard') }}">← Back to Dashboard</a>
</nav>
<div class="admin-wrap">
  @if(session('success'))<div class="flash">✓ {{ session('success') }}</div>@endif
  <div class="card">
    <div class="card-head">
      <div>
        <div class="card-title">Order #{{ $order->id }}</div>
        <div class="card-sub">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
      </div>
      <span class="status-badge" style="background:{{ $order->status_color }}22;color:{{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
    </div>
    <div class="card-body">
      <div class="detail-grid">
        <div class="detail-field"><div class="detail-label">Full Name</div><div class="detail-value">{{ $order->full_name }}</div></div>
        <div class="detail-field"><div class="detail-label">Phone</div><div class="detail-value"><a href="tel:{{ $order->phone }}" style="color:#c45c7a;text-decoration:none">{{ $order->phone }}</a></div></div>
        <div class="detail-field"><div class="detail-label">Email</div><div class="detail-value"><a href="mailto:{{ $order->email }}" style="color:#c45c7a;text-decoration:none;font-size:13px">{{ $order->email }}</a></div></div>
        @if($order->facebook)
        <div class="detail-field"><div class="detail-label">📘 Facebook</div><div class="detail-value"><a href="https://facebook.com/search/top?q={{ urlencode($order->facebook) }}" target="_blank" style="color:#1877f2;text-decoration:none">{{ $order->facebook }}</a></div></div>
        @endif
        @if($order->instagram)
        <div class="detail-field"><div class="detail-label">📸 Instagram</div><div class="detail-value"><a href="https://instagram.com/{{ ltrim($order->instagram,'@') }}" target="_blank" style="color:#c45c7a;text-decoration:none">{{ $order->instagram }}</a></div></div>
        @endif
        <div class="detail-field"><div class="detail-label">Order Type</div><div class="detail-value">{{ $order->order_type === 'delivery' ? '🚚 Delivery' : '🏠 Pickup' }}</div></div>
        @if($order->order_type === 'delivery')
        <div class="detail-field"><div class="detail-label">Address</div><div class="detail-value" style="font-size:14px">{{ $order->address }}</div></div>
        <div class="detail-field"><div class="detail-label">Delivery App</div><div class="detail-value">{{ $order->delivery_app }}</div></div>
        @endif
        @if($order->notes)
        <div class="detail-field" style="grid-column:span 2"><div class="detail-label">Special Notes</div><div class="detail-value" style="font-size:14px;font-weight:600">{{ $order->notes }}</div></div>
        @endif
      </div>
      <div style="margin-bottom:24px">
        <div class="detail-label" style="margin-bottom:12px">Items Ordered</div>
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
        <div class="items-total"><span>Total</span><span>₱{{ number_format($order->total,0) }}</span></div>
      </div>
      {{-- Update status --}}
      <form method="POST" action="{{ route('admin.updateStatus',$order) }}" style="margin-bottom:16px">
        @csrf @method('PATCH')
        <div class="action-row">
          <div class="form-group" style="margin:0">
            <select name="status" class="form-select">
              @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','ready'=>'Ready','completed'=>'Completed','cancelled'=>'Cancelled'] as $v=>$l)
                <option value="{{ $v }}" @selected($order->status===$v)>{{ $l }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Status</button>
          <a href="mailto:{{ $order->email }}?subject=Your MariaBakes Order %23{{ $order->id }}&body=Hi {{ $order->first_name }},%0A%0AThank you for ordering from MariaBakes!%0A%0A" class="btn btn-reply">✉ Reply via Email</a>
        </div>
      </form>
      {{-- Delete --}}
      <form method="POST" action="{{ route('admin.destroy',$order) }}" onsubmit="return confirm('Permanently delete this order?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-delete">🗑 Delete Order</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>

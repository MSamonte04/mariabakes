<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Order {{ $order->order_number }} – MariaBakes Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    *,*::before,*::after{cursor:default!important;}a,button,select{cursor:pointer!important;}input{cursor:text!important;}
    :root{--pink:#f9b8c4;--pink-deep:#c45c7a;--brown:#3d1f0f;--brown-mid:#7a3e1e;--cream:#fff8f0;--cream-dark:#fdeee0;}
    body{font-family:'Nunito',sans-serif;background:#f4f0eb;color:var(--brown);min-height:100vh;}
    nav{background:var(--brown);padding:16px 32px;display:flex;align-items:center;justify-content:space-between;}
    .nav-brand{font-family:'Playfair Display',serif;font-size:20px;color:white;}.nav-brand span{color:var(--pink);}
    .nav-links{display:flex;gap:16px;align-items:center;}.nav-links a{color:rgba(255,255,255,.6);text-decoration:none;font-weight:700;font-size:14px;transition:color .2s;}.nav-links a:hover{color:white;}
    .logout-btn{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:white;padding:8px 16px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;cursor:pointer;}
    .container{max-width:800px;margin:0 auto;padding:32px;}
    .card{background:white;border-radius:20px;overflow:hidden;box-shadow:0 2px 12px rgba(61,31,15,.06);margin-bottom:20px;}
    .card-head{background:var(--brown);padding:24px 28px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;}
    .card-head h2{font-family:'Playfair Display',serif;font-size:24px;color:white;}
    .card-head p{font-size:13px;color:rgba(255,255,255,.5);margin-top:4px;}
    .card-body{padding:28px;}
    .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .field-lbl{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);margin-bottom:4px;}
    .field-val{font-weight:700;font-size:15px;color:var(--brown);}
    .status-badge{display:inline-block;padding:6px 16px;border-radius:100px;font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;}
    .items-table{width:100%;border-collapse:collapse;}
    .items-table th{background:#f4f0eb;padding:10px 14px;text-align:left;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);}
    .items-table td{padding:12px 14px;border-bottom:1px solid rgba(61,31,15,.05);}
    .items-table tr:last-child td{border-bottom:none;font-weight:900;font-size:15px;}
    .flash{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;border-radius:12px;padding:12px 20px;margin-bottom:20px;font-weight:700;font-size:14px;}
    .finput{background:#fff8f0;border:2px solid rgba(61,31,15,.12);border-radius:12px;padding:10px 16px;font-family:'Nunito',sans-serif;font-size:14px;color:var(--brown);outline:none;transition:border-color .2s;}
    .finput:focus{border-color:var(--pink-deep);}
    .action-btn{display:inline-flex;align-items:center;padding:10px 20px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:800;font-size:14px;text-decoration:none;transition:all .2s;border:none;cursor:pointer;}
    .btn-primary{background:var(--brown);color:white;}.btn-primary:hover{background:var(--brown-mid);}
    .btn-outline{background:transparent;color:var(--brown);border:2px solid rgba(61,31,15,.2);}.btn-outline:hover{background:var(--brown);color:white;}
    .btn-danger{background:#fee2e2;color:#dc2626;border:none;}.btn-danger:hover{background:#fca5a5;}
    .btn-email{background:rgba(249,184,196,.3);color:var(--pink-deep);border:none;}.btn-email:hover{background:rgba(249,184,196,.5);}
  </style>
</head>
<body>
<nav>
  <div class="nav-brand"><span>Maria</span>Bakes Admin</div>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}">← Orders</a>
    <a href="{{ route('admin.products') }}">Products</a>
    <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">@csrf<button type="submit" class="logout-btn">Log Out</button></form>
  </div>
</nav>

<div class="container">
  @if(session('success'))<div class="flash">✓ {{ session('success') }}</div>@endif

  {{-- Order header --}}
  <div class="card">
    <div class="card-head">
      <div>
        <h2>{{ $order->order_number }}</h2>
        <p>Received {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
      </div>
      @php $colors = \App\Models\Order::statusColors(); @endphp
      <span class="status-badge" style="background:{{ $colors[$order->status] }}22;color:{{ $colors[$order->status] }}">{{ ucfirst($order->status) }}</span>
    </div>
    <div class="card-body">
      <div class="grid2" style="margin-bottom:20px">
        <div><div class="field-lbl">Full Name</div><div class="field-val">{{ $order->full_name }}</div></div>
        <div><div class="field-lbl">Email</div><div class="field-val"><a href="mailto:{{ $order->email }}" style="color:var(--pink-deep);text-decoration:none">{{ $order->email }}</a></div></div>
        <div><div class="field-lbl">Phone</div><div class="field-val">{{ $order->phone }}</div></div>
        <div><div class="field-lbl">Order Type</div><div class="field-val">{{ ucfirst($order->order_type) }}</div></div>
        @if($order->address)
        <div><div class="field-lbl">Address</div><div class="field-val">{{ $order->address }}</div></div>
        @endif
        @if($order->delivery_app)
        <div><div class="field-lbl">Delivery App</div><div class="field-val">{{ $order->delivery_app }}</div></div>
        @endif
        <div><div class="field-lbl">Preferred Date</div><div class="field-val">{{ $order->preferred_date }}</div></div>
        <div><div class="field-lbl">Preferred Time</div><div class="field-val">{{ $order->preferred_time }}</div></div>
      </div>
      @if($order->notes)
      <div style="background:#fff8f0;border-radius:12px;padding:14px 18px;font-size:14px;color:rgba(61,31,15,.7);line-height:1.6;">
        <div class="field-lbl" style="margin-bottom:6px">Special Notes</div>{{ $order->notes }}
      </div>
      @endif
    </div>
  </div>

  {{-- Order items --}}
  <div class="card">
    <div style="padding:20px 28px;border-bottom:1px solid rgba(61,31,15,.06)">
      <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:var(--brown)">Order Items</h3>
    </div>
    <div style="overflow-x:auto">
      <table class="items-table">
        <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
        <tbody>
          @foreach($order->items as $item)
          <tr><td>{{ $item->product_name }}</td><td>₱{{ number_format($item->product_price,0) }}</td><td>×{{ $item->quantity }}</td><td>₱{{ number_format($item->subtotal,0) }}</td></tr>
          @endforeach
          <tr style="background:#fff8f0"><td colspan="3" style="text-align:right;padding-right:20px">Total</td><td style="color:var(--pink-deep)">₱{{ number_format($order->total,0) }}</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- Actions --}}
  <div class="card">
    <div class="card-body">
      {{-- Update status --}}
      <form method="POST" action="{{ route('admin.order.status', $order) }}" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;margin-bottom:20px;">
        @csrf @method('PATCH')
        <div>
          <div class="field-lbl" style="margin-bottom:6px">Update Status</div>
          <select name="status" class="finput">
            @foreach(\App\Models\Order::statusLabels() as $val=>$lbl)
              <option value="{{ $val }}" @selected($order->status===$val)>{{ $lbl }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="action-btn btn-primary">Update Status</button>
        <a href="mailto:{{ $order->email }}?subject=Your Order {{ $order->order_number }} – MariaBakes&body=Hi {{ $order->first_name }},%0A%0AThank you for your order with MariaBakes!%0A%0A"
           class="action-btn btn-email">✉ Reply via Email</a>
      </form>

      {{-- Delete - separate form --}}
      <form method="POST" action="{{ route('admin.order.destroy', $order) }}" onsubmit="return confirm('Permanently delete this order?')">
        @csrf @method('DELETE')
        <button type="submit" class="action-btn btn-danger">Delete Order</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>MariaBakes Admin – Orders</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  @vite(['resources/css/app.css'])
  <style>
    *,*::before,*::after{cursor:default!important}
    a,button,select,.clickable-row{cursor:pointer!important}
    input,textarea{cursor:text!important}
    body{font-family:'Nunito',sans-serif;background:#f4f0eb;color:#3d1f0f;min-height:100vh;margin:0;padding:0;}
    .admin-nav{background:#3d1f0f;padding:16px 24px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;gap:12px;}
    .admin-nav-logo{font-family:'Playfair Display',serif;font-size:20px;color:white;white-space:nowrap;}
    .admin-nav-logo span{color:#f9b8c4;}
    .nav-links{display:flex;gap:12px;align-items:center;}
    .nav-links a{color:rgba(255,255,255,.6);font-size:14px;font-weight:700;text-decoration:none;transition:color .2s;white-space:nowrap;}
    .nav-links a:hover,.nav-links a.active{color:white;}
    .admin-wrap{max-width:1300px;margin:0 auto;padding:32px 20px;}
    .page-title{font-family:'Playfair Display',serif;font-size:26px;color:#3d1f0f;margin-bottom:20px;}
    .page-title span{color:#c45c7a;font-style:italic;}
    .stat-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:14px;margin-bottom:24px;}
    .stat-card{background:white;border-radius:14px;padding:18px 20px;border:1px solid rgba(61,31,15,.06);}
    .stat-card-num{font-family:'Playfair Display',serif;font-size:30px;line-height:1;color:#3d1f0f;}
    .stat-card-num.pink{color:#c45c7a;}
    .stat-card-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.4);margin-top:4px;}
    .flash{background:#dcfce7;border:1px solid #86efac;color:#166534;border-radius:12px;padding:12px 20px;margin-bottom:16px;font-weight:700;font-size:14px;}
    .filter-card{background:white;border-radius:14px;padding:18px 20px;margin-bottom:16px;border:1px solid rgba(61,31,15,.06);}
    .filter-form{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;}
    .f-group{display:flex;flex-direction:column;gap:5px;}
    .f-label{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.5);}
    .f-input{background:#fff8f0;border:2px solid rgba(61,31,15,.12);border-radius:10px;padding:9px 13px;font-family:'Nunito',sans-serif;font-size:14px;color:#3d1f0f;outline:none;}
    .f-input:focus{border-color:#e8849a;}
    .f-btn{padding:9px 18px;border-radius:100px;border:none;font-family:'Nunito',sans-serif;font-weight:800;font-size:13px;}
    .f-btn-primary{background:#3d1f0f;color:white;}
    .f-btn-outline{background:transparent;border:2px solid rgba(61,31,15,.2);color:#3d1f0f;text-decoration:none;display:inline-flex;align-items:center;}
    .f-btn-outline:hover{background:#3d1f0f;color:white;}
    .table-card{background:white;border-radius:14px;overflow:hidden;border:1px solid rgba(61,31,15,.06);}
    .table-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;}
    table{width:100%;border-collapse:collapse;min-width:480px;}
    thead tr{background:#3d1f0f;}
    thead th{padding:13px 16px;text-align:left;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.7);white-space:nowrap;}
    tbody tr.clickable-row{border-bottom:1px solid rgba(61,31,15,.05);transition:background .15s;}
    tbody tr.clickable-row:hover{background:#fff0f5;}
    tbody td{padding:14px 16px;font-size:14px;vertical-align:middle;}
    .status-badge{display:inline-block;padding:4px 12px;border-radius:100px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;}
    .new-badge{background:#fff0f5;color:#c45c7a;font-size:10px;font-weight:900;padding:2px 8px;border-radius:100px;margin-left:6px;text-transform:uppercase;vertical-align:middle;}
    .customer-name{font-weight:800;color:#3d1f0f;}
    .customer-sub{font-size:12px;color:rgba(61,31,15,.45);margin-top:2px;}
    .empty-row td{text-align:center;padding:48px;color:rgba(61,31,15,.35);font-size:15px;}
    .page-links{padding:14px 20px;border-top:1px solid rgba(61,31,15,.05);}
    @media(max-width:600px){
      .admin-nav{padding:12px 16px;}
      .admin-wrap{padding:20px 14px;}
    }
  </style>
</head>
<body>
<nav class="admin-nav">
  <div class="admin-nav-logo"><span>Maria</span>Bakes Admin</div>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}" class="active">Orders</a>
    <a href="{{ route('admin.products') }}">Products</a>
    <a href="{{ route('home') }}" target="_blank">View Site</a>
  </div>
</nav>

<div class="admin-wrap">
  <h1 class="page-title">Orders <span>Dashboard</span></h1>

  <div class="stat-cards">
    <div class="stat-card">
      <div class="stat-card-num pink">{{ $totalNew }}</div>
      <div class="stat-card-label">Pending</div>
    </div>
    <div class="stat-card">
      <div class="stat-card-num">{{ $totalAll }}</div>
      <div class="stat-card-label">Total Orders</div>
    </div>
    <div class="stat-card">
      <div class="stat-card-num" style="font-size:20px;">₱{{ number_format($totalSales, 0) }}</div>
      <div class="stat-card-label">Completed Sales</div>
    </div>
  </div>

  @if(session('success'))
    <div class="flash">✓ {{ session('success') }}</div>
  @endif

  <div class="filter-card">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="filter-form">
      <div class="f-group" style="flex:1;min-width:160px">
        <label class="f-label">Search</label>
        <input class="f-input" type="text" name="search" value="{{ $request->search ?? '' }}" placeholder="Name, email, phone...">
      </div>
      <div class="f-group">
        <label class="f-label">Status</label>
        <select class="f-input" name="status">
          @foreach(['all'=>'All','pending'=>'Pending','confirmed'=>'Confirmed','ready'=>'Ready','completed'=>'Completed','cancelled'=>'Cancelled'] as $v=>$l)
            <option value="{{ $v }}" @selected(($request->status ?? 'all')===$v)>{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <button class="f-btn f-btn-primary" type="submit">Filter</button>
      <a href="{{ route('admin.dashboard') }}" class="f-btn f-btn-outline">Reset</a>
    </form>
  </div>

  <div class="table-card">
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
          <tr class="clickable-row" onclick="window.location='{{ route('admin.show', $order) }}'">
            <td style="color:rgba(61,31,15,.4);font-size:13px">#{{ $order->id }}</td>
            <td>
              <div class="customer-name">
                {{ $order->full_name }}
                @if($order->status==='pending')<span class="new-badge">New</span>@endif
              </div>
              <div class="customer-sub">{{ $order->phone }}</div>
              <div class="customer-sub">{{ $order->order_type==='delivery' ? '🚚 Delivery' : '🏠 Pickup' }}</div>
            </td>
            <td style="font-size:13px;color:rgba(61,31,15,.6);max-width:160px">{{ Str::limit($order->items_summary,55) }}</td>
            <td style="font-weight:900;white-space:nowrap">₱{{ number_format($order->total,0) }}</td>
            <td><span class="status-badge" style="background:{{ $order->status_color }}22;color:{{ $order->status_color }}">{{ ucfirst($order->status) }}</span></td>
            <td style="font-size:13px;color:rgba(61,31,15,.4);white-space:nowrap">{{ $order->created_at->diffForHumans() }}</td>
          </tr>
          @empty
          <tr class="empty-row"><td colspan="6">No orders yet 🍪</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($orders->hasPages())<div class="page-links">{{ $orders->links() }}</div>@endif
  </div>
</div>
</body>
</html>

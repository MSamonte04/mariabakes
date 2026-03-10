<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Products – MariaBakes Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    *,*::before,*::after{cursor:default!important;}a,button,select{cursor:pointer!important;}input{cursor:text!important;}
    :root{--pink:#f9b8c4;--pink-deep:#c45c7a;--brown:#3d1f0f;--brown-mid:#7a3e1e;--cream:#fff8f0;}
    body{font-family:'Nunito',sans-serif;background:#f4f0eb;color:var(--brown);min-height:100vh;}
    nav{background:var(--brown);padding:16px 32px;display:flex;align-items:center;justify-content:space-between;}
    .nav-brand{font-family:'Playfair Display',serif;font-size:20px;color:white;}.nav-brand span{color:var(--pink);}
    .nav-links{display:flex;gap:16px;align-items:center;}.nav-links a{color:rgba(255,255,255,.6);text-decoration:none;font-weight:700;font-size:14px;}.nav-links a:hover,.nav-links a.active{color:white;}
    .logout-btn{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:white;padding:8px 16px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;cursor:pointer;}
    .container{max-width:1100px;margin:0 auto;padding:32px;}
    .page-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;}
    .page-title{font-family:'Playfair Display',serif;font-size:28px;color:var(--brown);}
    .btn-add{background:var(--pink-deep);color:white;padding:12px 24px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:800;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s;}
    .btn-add:hover{background:var(--brown);}
    .products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .pcard{background:white;border-radius:20px;overflow:hidden;box-shadow:0 2px 12px rgba(61,31,15,.06);transition:all .25s;}
    .pcard:hover{box-shadow:0 8px 24px rgba(61,31,15,.1);}
    .pcard-img{width:100%;aspect-ratio:4/3;object-fit:cover;background:#f4f0eb;display:flex;align-items:center;justify-content:center;font-size:48px;}
    .pcard-img img{width:100%;height:100%;object-fit:cover;display:block;}
    .pcard-body{padding:16px;}
    .pcard-cat{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--pink-deep);margin-bottom:4px;}
    .pcard-name{font-family:'Playfair Display',serif;font-size:18px;color:var(--brown);margin-bottom:4px;}
    .pcard-price{font-size:18px;font-weight:900;color:var(--brown);}
    .pcard-price span{font-size:12px;font-weight:600;color:rgba(61,31,15,.4);}
    .avail-badge{display:inline-block;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:800;text-transform:uppercase;margin-top:6px;}
    .avail-yes{background:#d1fae5;color:#065f46;}
    .avail-no{background:#fee2e2;color:#dc2626;}
    .pcard-actions{padding:12px 16px;border-top:1px solid rgba(61,31,15,.06);display:flex;gap:8px;}
    .action-btn{flex:1;text-align:center;padding:8px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;text-decoration:none;cursor:pointer;border:none;transition:all .2s;}
    .btn-edit{background:#fef3c7;color:#92400e;}.btn-edit:hover{background:#fde68a;}
    .btn-del{background:#fee2e2;color:#dc2626;}.btn-del:hover{background:#fca5a5;}
    .flash{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;border-radius:12px;padding:12px 20px;margin-bottom:20px;font-weight:700;font-size:14px;}
    .empty{text-align:center;padding:64px;color:rgba(61,31,15,.4);}
  </style>
</head>
<body>
<nav>
  <div class="nav-brand"><span>Maria</span>Bakes Admin</div>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}">Orders</a>
    <a href="{{ route('admin.products') }}" class="active">Products</a>
    <a href="{{ route('home') }}" target="_blank">View Site</a>
    <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">@csrf<button type="submit" class="logout-btn">Log Out</button></form>
  </div>
</nav>

<div class="container">
  @if(session('success'))<div class="flash">✓ {{ session('success') }}</div>@endif

  <div class="page-head">
    <h1 class="page-title">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn-add">+ Add Product</a>
  </div>

  @if($products->isEmpty())
  <div class="empty"><div style="font-size:48px;margin-bottom:16px">🍪</div><p style="font-weight:700">No products yet. Add your first product!</p></div>
  @else
  <div class="products-grid">
    @foreach($products as $product)
    <div class="pcard">
      @if($product->image_url)
        <div class="pcard-img"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"></div>
      @else
        <div class="pcard-img">🍪</div>
      @endif
      <div class="pcard-body">
        <div class="pcard-cat">{{ \App\Models\Product::categories()[$product->category] ?? $product->category }}</div>
        <div class="pcard-name">{{ $product->name }}</div>
        <div class="pcard-price">₱{{ number_format($product->price,0) }} <span>{{ $product->unit }}</span></div>
        <span class="avail-badge {{ $product->available ? 'avail-yes' : 'avail-no' }}">{{ $product->available ? 'Available' : 'Sold Out' }}</span>
      </div>
      <div class="pcard-actions">
        <a href="{{ route('admin.products.edit', $product) }}" class="action-btn btn-edit">Edit</a>
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete {{ $product->name }}?')" style="flex:1">
          @csrf @method('DELETE')
          <button type="submit" class="action-btn btn-del" style="width:100%">Delete</button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>
</body>
</html>

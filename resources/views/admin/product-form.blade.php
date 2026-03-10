<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $product ? 'Edit' : 'Add' }} Product – MariaBakes Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css'])
  <style>
    *,*::before,*::after{cursor:default!important;}a,button,select,label[for]{cursor:pointer!important;}input,textarea,select{cursor:text!important;}
    :root{--pink:#f9b8c4;--pink-deep:#c45c7a;--brown:#3d1f0f;--brown-mid:#7a3e1e;--cream:#fff8f0;}
    body{font-family:'Nunito',sans-serif;background:#f4f0eb;color:var(--brown);min-height:100vh;}
    nav{background:var(--brown);padding:16px 32px;display:flex;align-items:center;justify-content:space-between;}
    .nav-brand{font-family:'Playfair Display',serif;font-size:20px;color:white;}.nav-brand span{color:var(--pink);}
    .nav-links{display:flex;gap:16px;align-items:center;}.nav-links a{color:rgba(255,255,255,.6);text-decoration:none;font-weight:700;font-size:14px;}.nav-links a:hover{color:white;}
    .logout-btn{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:white;padding:8px 16px;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:700;font-size:13px;cursor:pointer;}
    .container{max-width:640px;margin:0 auto;padding:32px;}
    .card{background:white;border-radius:20px;padding:32px;box-shadow:0 2px 12px rgba(61,31,15,.06);}
    .page-title{font-family:'Playfair Display',serif;font-size:28px;color:var(--brown);margin-bottom:28px;}
    .fgroup{margin-bottom:20px;}
    .flabel{display:block;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(61,31,15,.5);margin-bottom:6px;}
    .finput{width:100%;background:#fff8f0;border:2px solid rgba(61,31,15,.12);border-radius:14px;padding:14px 18px;font-family:'Nunito',sans-serif;font-size:15px;color:var(--brown);outline:none;transition:border-color .2s;}
    .finput:focus{border-color:var(--pink-deep);}
    .frow{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .ferr{display:block;color:#e84545;font-size:12px;font-weight:700;margin-top:4px;}
    .img-preview{width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:14px;margin-bottom:12px;background:#f4f0eb;display:flex;align-items:center;justify-content:center;font-size:48px;overflow:hidden;}
    .img-preview img{width:100%;height:100%;object-fit:cover;}
    .toggle-wrap{display:flex;align-items:center;gap:12px;}
    .toggle{width:48px;height:26px;border-radius:13px;background:rgba(61,31,15,.15);position:relative;cursor:pointer;transition:background .2s;}
    .toggle.on{background:var(--pink-deep);}
    .toggle-knob{width:20px;height:20px;border-radius:50%;background:white;position:absolute;top:3px;left:3px;transition:transform .2s;box-shadow:0 2px 4px rgba(0,0,0,.15);}
    .toggle.on .toggle-knob{transform:translateX(22px);}
    .toggle-lbl{font-weight:700;font-size:14px;color:var(--brown);}
    .btn-submit{width:100%;padding:16px;background:var(--brown);color:white;border:none;border-radius:100px;font-family:'Nunito',sans-serif;font-weight:800;font-size:15px;cursor:pointer;transition:all .25s;margin-top:8px;}
    .btn-submit:hover{background:var(--brown-mid);}
    .btn-back{display:inline-flex;align-items:center;gap:8px;color:rgba(61,31,15,.5);text-decoration:none;font-weight:700;font-size:14px;margin-bottom:20px;transition:color .2s;}
    .btn-back:hover{color:var(--brown);}
  </style>
</head>
<body>
<nav>
  <div class="nav-brand"><span>Maria</span>Bakes Admin</div>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}">Orders</a>
    <a href="{{ route('admin.products') }}">Products</a>
    <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">@csrf<button type="submit" class="logout-btn">Log Out</button></form>
  </div>
</nav>

<div class="container">
  <a href="{{ route('admin.products') }}" class="btn-back">← Back to Products</a>
  <div class="card">
    <h1 class="page-title">{{ $product ? 'Edit Product' : 'Add New Product' }}</h1>

    <form method="POST"
      action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data">
      @csrf
      @if($product) @method('PATCH') @endif

      {{-- Image preview --}}
      <div class="fgroup">
        <label class="flabel">Product Photo</label>
        <div class="img-preview" id="img-preview">
          @if($product && $product->image_url)
            <img src="{{ $product->image_url }}" id="preview-img" alt="preview">
          @else
            <span id="preview-placeholder">🍪</span>
          @endif
        </div>
        <input type="file" name="image" id="image-input" accept="image/*" class="finput" onchange="previewImage(event)">
        @error('image')<span class="ferr">{{ $message }}</span>@enderror
        @if($product && $product->image)<p style="font-size:12px;color:rgba(61,31,15,.4);margin-top:6px;">Leave empty to keep current photo</p>@endif
      </div>

      <div class="fgroup">
        <label class="flabel">Product Name *</label>
        <input type="text" name="name" value="{{ old('name', $product?->name) }}" class="finput" placeholder="e.g. Classic Chocolate Chip" required>
        @error('name')<span class="ferr">{{ $message }}</span>@enderror
      </div>

      <div class="frow">
        <div class="fgroup">
          <label class="flabel">Category *</label>
          <select name="category" class="finput" required>
            @foreach(\App\Models\Product::categories() as $val => $lbl)
              <option value="{{ $val }}" @selected(old('category', $product?->category) === $val)>{{ $lbl }}</option>
            @endforeach
          </select>
          @error('category')<span class="ferr">{{ $message }}</span>@enderror
        </div>
        <div class="fgroup">
          <label class="flabel">Tag (optional)</label>
          <input type="text" name="tag" value="{{ old('tag', $product?->tag) }}" class="finput" placeholder="e.g. Bestseller, New">
          @error('tag')<span class="ferr">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="frow">
        <div class="fgroup">
          <label class="flabel">Price (₱) *</label>
          <input type="number" name="price" value="{{ old('price', $product?->price) }}" class="finput" placeholder="65" step="0.01" min="0" required>
          @error('price')<span class="ferr">{{ $message }}</span>@enderror
        </div>
        <div class="fgroup">
          <label class="flabel">Unit *</label>
          <input type="text" name="unit" value="{{ old('unit', $product?->unit ?? 'per pc') }}" class="finput" placeholder="per pc / per box / whole">
          @error('unit')<span class="ferr">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="fgroup">
        <label class="flabel">Description</label>
        <textarea name="description" rows="2" class="finput" placeholder="Short description of the product...">{{ old('description', $product?->description) }}</textarea>
        @error('description')<span class="ferr">{{ $message }}</span>@enderror
      </div>

      <div class="fgroup">
        <label class="flabel">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $product?->sort_order ?? 0) }}" class="finput" placeholder="0">
        <p style="font-size:12px;color:rgba(61,31,15,.4);margin-top:4px;">Lower number = shows first in menu</p>
      </div>

      {{-- Available toggle --}}
      <div class="fgroup">
        <label class="flabel">Availability</label>
        <div class="toggle-wrap">
          <div class="toggle {{ old('available', $product?->available ?? true) ? 'on' : '' }}" id="toggle" onclick="toggleAvail()">
            <div class="toggle-knob"></div>
          </div>
          <span class="toggle-lbl" id="toggle-lbl">{{ old('available', $product?->available ?? true) ? 'Available' : 'Sold Out' }}</span>
          <input type="hidden" name="available" id="avail-input" value="{{ old('available', $product?->available ?? true) ? '1' : '' }}">
        </div>
      </div>

      <button type="submit" class="btn-submit">{{ $product ? 'Save Changes' : 'Add Product' }} →</button>
    </form>
  </div>
</div>

<script>
function previewImage(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = ev => {
    const preview = document.getElementById('img-preview');
    preview.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
  };
  reader.readAsDataURL(file);
}

function toggleAvail() {
  const t = document.getElementById('toggle');
  const lbl = document.getElementById('toggle-lbl');
  const input = document.getElementById('avail-input');
  const isOn = t.classList.toggle('on');
  lbl.textContent = isOn ? 'Available' : 'Sold Out';
  input.value = isOn ? '1' : '';
}
</script>
</body>
</html>

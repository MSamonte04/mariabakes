@extends('layouts.app')

@section('title', 'MariaBakes – Homemade by Ching')

@section('content')

{{-- ═══ HERO ═══ --}}
<section id="hero">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">✨ Homemade with love</div>
    <h1 class="hero-title">Baked Fresh,<br><em>Just for You</em></h1>
    <p class="hero-sub">Handcrafted cookies, fudgy brownies, and custom cookie cakes made with the finest ingredients. Every bite tells a story.</p>
    <div class="hero-btns">
      <a href="#menu" class="btn-primary">🍪 Order Now</a>
      <a href="#about" class="btn-outline">Our Story →</a>
    </div>
  </div>
  <div class="hero-image">
    <div class="hero-img-wrap">
      {{-- Replace with: <img src="{{ asset('images/products/hero.jpg') }}" alt="MariaBakes"> --}}
      <div class="hero-img-placeholder">🍪</div>
    </div>
    <div class="hero-badges">
      <div class="hero-badge"><span>🍫</span> Fudgy Brownies</div>
      <div class="hero-badge" style="animation-delay:-2.5s"><span>🎂</span> Cookie Cakes</div>
      <div class="hero-badge" style="animation-delay:-5s"><span>📦</span> Gift Boxes</div>
    </div>
  </div>
</section>

{{-- ═══ MENU ═══ --}}
<section id="menu" class="section">
  <div class="section-header reveal">
    <div class="section-label">🍪 Our Menu</div>
    <h2 class="section-title">Sweet <em>Treats</em></h2>
    <p class="section-sub">Every item is made to order, baked fresh on the day of pickup or delivery.</p>
    <p class="section-note">⏰ Please order at least 1–2 days in advance.</p>
  </div>
  <div class="menu-filters reveal">
    <button class="filter-btn active" onclick="filterMenu('all',this)">All</button>
    <button class="filter-btn" onclick="filterMenu('cookies',this)">Cookies</button>
    <button class="filter-btn" onclick="filterMenu('brownies',this)">Brownies</button>
    <button class="filter-btn" onclick="filterMenu('cookie-cakes',this)">Cookie Cakes</button>
    <button class="filter-btn" onclick="filterMenu('boxes',this)">Gift Boxes</button>
  </div>
  <div class="menu-grid" id="menu-grid">
    @foreach($products as $p)
    <div class="product-card reveal" data-category="{{ $p['category'] }}">
      @if(!$p['available'])<span class="sold-out-badge">Sold Out</span>@endif
      <div class="product-img">
        {{-- To use a real photo: <img src="{{ asset('images/products/product-'.$p['id'].'.jpg') }}" alt="{{ $p['name'] }}"> --}}
        <span class="product-emoji">{{ $p['emoji'] }}</span>
      </div>
      <div class="product-body">
        <span class="product-tag">{{ $p['tag'] }}</span>
        <div class="product-name">{{ $p['name'] }}</div>
        <div class="product-desc">{{ $p['desc'] }}</div>
        <div class="product-footer">
          <div class="product-price">₱{{ number_format($p['price']) }} <span>{{ $p['unit'] }}</span></div>
          @if($p['available'])
            <button class="add-btn" onclick="addToCart({{ $p['id'] }})">+ Add</button>
          @else
            <button class="add-btn" disabled style="opacity:.4;cursor:not-allowed">Sold Out</button>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

{{-- ═══ GALLERY ═══ --}}
<section id="gallery" class="section section-alt">
  <div class="section-header reveal" style="text-align:center">
    <div class="section-label">📸 Gallery</div>
    <h2 class="section-title">Made with <em>Love</em></h2>
  </div>
  <div class="gallery-grid reveal">
    {{-- Replace divs with <img src="{{ asset('images/gallery/1.jpg') }}" alt="..."> --}}
    <div class="gallery-item g-wide"><div class="gallery-placeholder" style="background:linear-gradient(135deg,#f9b8c4,#fdeee0)">🍪</div><div class="gallery-overlay"><span>Cookie Collection</span></div></div>
    <div class="gallery-item"><div class="gallery-placeholder" style="background:linear-gradient(135deg,#7a3e1e,#c4855a)">🍫</div><div class="gallery-overlay"><span>Fudgy Brownies</span></div></div>
    <div class="gallery-item"><div class="gallery-placeholder" style="background:linear-gradient(135deg,#e8849a,#f9b8c4)">🎂</div><div class="gallery-overlay"><span>Cookie Cakes</span></div></div>
    <div class="gallery-item g-wide"><div class="gallery-placeholder" style="background:linear-gradient(135deg,#fdeee0,#f9b8c4)">🎁</div><div class="gallery-overlay"><span>Gift Boxes</span></div></div>
    <div class="gallery-item"><div class="gallery-placeholder" style="background:linear-gradient(135deg,#3d1f0f,#7a3e1e)">💝</div><div class="gallery-overlay"><span>Special Orders</span></div></div>
  </div>
</section>

{{-- ═══ ABOUT ═══ --}}
<section id="about" class="section">
  <div class="about-wrap">
    <div class="about-img-col reveal">
      <div class="about-img-grid">
        <div class="about-img-item wide"><div class="gallery-placeholder" style="aspect-ratio:16/9;background:linear-gradient(135deg,#f9b8c4,#fdeee0)">🍪</div></div>
        <div class="about-img-item"><div class="gallery-placeholder" style="aspect-ratio:1/1;background:linear-gradient(135deg,#7a3e1e,#c4855a)">🍫</div></div>
        <div class="about-img-item"><div class="gallery-placeholder" style="aspect-ratio:1/1;background:linear-gradient(135deg,#e8849a,#f9b8c4)">🎂</div></div>
      </div>
    </div>
    <div class="about-text reveal">
      <div class="section-label">💕 Our Story</div>
      <h2 class="section-title">About <em>MariaBakes</em></h2>
      <blockquote class="about-quote">"Every cookie carries a little piece of my heart."</blockquote>
      <p class="about-body">Hi! I'm Ching, and MariaBakes is my small homemade bakery born out of pure love for baking. What started as weekend treats for family turned into something I never expected — a community of people who love sweets as much as I do.</p>
      <p class="about-body">I believe in using quality ingredients, baking everything fresh, and adding a personal touch to every order. Whether it's a simple box of cookies or a custom cookie cake — I put my heart into every single bake.</p>
      <div class="about-stats">
        <div class="stat"><div class="stat-num">100%</div><div class="stat-label">Homemade</div></div>
        <div class="stat"><div class="stat-num">Fresh</div><div class="stat-label">Every Order</div></div>
        <div class="stat"><div class="stat-num">❤️</div><div class="stat-label">Made with Love</div></div>
      </div>
    </div>
  </div>
</section>

{{-- ═══ CONTACT ═══ --}}
<section id="contact" class="section section-dark">
  <div class="section-header reveal" style="text-align:center">
    <div class="section-label">📩 Get in Touch</div>
    <h2 class="section-title">Let's <em>Connect</em></h2>
    <p class="section-sub" style="margin:0 auto">Questions? Custom orders? Reach out anytime!</p>
  </div>
  <div class="contact-wrap">
    <div class="contact-info reveal">
      <div class="contact-cards">
        <div class="contact-card"><span>📍</span><div><div class="cc-label">Location</div><div class="cc-val">Dasmarinas, Cavite, Philippines</div></div></div>
        <div class="contact-card"><span>⏰</span><div><div class="cc-label">Order Lead Time</div><div class="cc-val">1–2 days in advance</div></div></div>
        <div class="contact-card"><span>💳</span><div><div class="cc-label">Payment</div><div class="cc-val">GCash or Cash on Pickup/Delivery</div></div></div>
        <div class="contact-card"><span>🚚</span><div><div class="cc-label">Delivery</div><div class="cc-val">Lalamove, Grab Express</div></div></div>
      </div>
    </div>
    <div class="contact-socials reveal">
      <p class="socials-title">Follow us & send us a message:</p>
      <a href="https://facebook.com" target="_blank" class="social-btn">
        <span class="social-icon">📘</span>
        <div><div class="social-platform">Facebook</div><div class="social-handle">MariaBakes by Ching</div></div>
      </a>
      <a href="https://instagram.com" target="_blank" class="social-btn">
        <span class="social-icon">📸</span>
        <div><div class="social-platform">Instagram</div><div class="social-handle">@mariabakes</div></div>
      </a>
      <div class="contact-note">
        💬 Message us on Facebook or Instagram for custom orders, bulk orders, or any questions!
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let selectedApp = '';

// ── CART ──
async function addToCart(id) {
  const res = await fetch('{{ route("cart.add") }}', {
    method:'POST',
    headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json','Accept':'application/json'},
    body: JSON.stringify({product_id: id}),
  });
  const data = await res.json();
  if (data.success) { updateCartUI(data.cart); showToast('🍪 Added to cart!'); }
}

async function removeFromCart(id) {
  const res = await fetch('{{ route("cart.remove") }}', {
    method:'POST',
    headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json','Accept':'application/json'},
    body: JSON.stringify({product_id: id}),
  });
  const data = await res.json();
  if (data.success) updateCartUI(data.cart);
}

async function changeQty(id, delta) {
  const countEl = document.querySelector(`[data-qty="${id}"]`);
  const currentQty = parseInt(countEl?.textContent || 1);
  const newQty = currentQty + delta;
  const res = await fetch('{{ route("cart.update") }}', {
    method:'POST',
    headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json','Accept':'application/json'},
    body: JSON.stringify({product_id: id, qty: newQty}),
  });
  const data = await res.json();
  if (data.success) updateCartUI(data.cart);
}

function updateCartUI(cart) {
  const items   = Object.values(cart);
  const total   = items.reduce((s,x) => s + x.price * x.qty, 0);
  const count   = items.reduce((s,x) => s + x.qty, 0);
  const countEl = document.getElementById('cart-count');
  countEl.textContent = count;
  countEl.style.display = count > 0 ? 'flex' : 'none';
  document.getElementById('cart-total').textContent = '₱' + total.toLocaleString();
  document.getElementById('checkout-btn').disabled = items.length === 0;
  const list = document.getElementById('cart-items-list');
  if (items.length === 0) {
    list.innerHTML = `<div class="cart-empty"><div style="font-size:48px;margin-bottom:12px">🛒</div><div>Your cart is empty</div><div style="font-size:13px;margin-top:8px;opacity:.5">Add some treats!</div></div>`;
    return;
  }
  list.innerHTML = items.map(item => `
    <div class="cart-item">
      <div class="cart-item-img">${item.emoji}</div>
      <div class="cart-item-info">
        <div class="cart-item-name">${item.name}</div>
        <div class="cart-item-price">₱${(item.price * item.qty).toLocaleString()}</div>
        <div class="cart-item-qty">
          <button class="qty-btn" onclick="changeQty(${item.id},-1)">−</button>
          <span class="qty-num" data-qty="${item.id}">${item.qty}</span>
          <button class="qty-btn" onclick="changeQty(${item.id},1)">+</button>
        </div>
      </div>
      <button class="cart-remove" onclick="removeFromCart(${item.id})">✕</button>
    </div>`).join('');
}

// ── CART DRAWER ──
function openCart()  { document.getElementById('cart-drawer').classList.add('open'); document.getElementById('cart-overlay').classList.add('open'); }
function closeCart() { document.getElementById('cart-drawer').classList.remove('open'); document.getElementById('cart-overlay').classList.remove('open'); }

// ── CHECKOUT ──
function openCheckout() {
  closeCart();
  const items = Object.values(JSON.parse(sessionStorage.getItem('mb_cart') || '{}'));
  const cartItemsEl = document.getElementById('cart-items-list');
  // Rebuild summary from DOM cart
  const cartText = cartItemsEl.querySelectorAll('.cart-item-name');
  const cartPrices = cartItemsEl.querySelectorAll('.cart-item-price');
  let summaryHTML = '<div class="order-summary-title">Order Summary</div>';
  cartText.forEach((n,i) => {
    summaryHTML += `<div class="order-summary-item"><span>${n.textContent}</span><span>${cartPrices[i]?.textContent||''}</span></div>`;
  });
  const total = document.getElementById('cart-total').textContent;
  summaryHTML += `<hr class="order-summary-divider"><div class="order-summary-total"><span>Total</span><span>${total}</span></div>`;
  document.getElementById('checkout-summary').innerHTML = summaryHTML;
  document.getElementById('checkout-modal').classList.add('open');
}
function closeCheckout() { document.getElementById('checkout-modal').classList.remove('open'); openCart(); }
function closeSuccess()  { document.getElementById('success-modal').classList.remove('open'); }

function onOrderType(type) {
  document.getElementById('delivery-fields').style.display = type === 'delivery' ? 'block' : 'none';
}

function selectApp(name, el) {
  selectedApp = name;
  document.querySelectorAll('.app-option').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
}

function clearErrors() {
  document.querySelectorAll('.field-error').forEach(e => e.textContent = '');
}

async function submitOrder() {
  clearErrors();
  const btn = document.getElementById('submit-btn');
  btn.disabled = true;
  btn.textContent = 'Placing Order...';

  // Get reCAPTCHA token
  let recaptcha_token = '';
  try {
    recaptcha_token = await new Promise(resolve => {
      if (typeof grecaptcha !== 'undefined') {
        grecaptcha.ready(() => {
          grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY","") }}', {action:'order'}).then(resolve);
        });
      } else { resolve(''); }
    });
  } catch(e) { recaptcha_token = ''; }

  const orderType = document.querySelector('input[name="order_type"]:checked')?.value;
  const payload = {
    recaptcha_token,
    first_name:   document.getElementById('f-fname').value.trim(),
    last_name:    document.getElementById('f-lname').value.trim(),
    phone:        document.getElementById('f-phone').value.trim(),
    email:        document.getElementById('f-email').value.trim(),
    facebook:     document.getElementById('f-facebook')?.value.trim() || '',
    instagram:    document.getElementById('f-instagram')?.value.trim() || '',
    order_type:   orderType,
    address:      document.getElementById('f-address').value.trim(),
    delivery_app: selectedApp,
    notes:        document.getElementById('f-notes').value.trim(),
    website:      document.getElementById('hp-website').value,
  };

  try {
    const res = await fetch('{{ route("order.store") }}', {
      method:'POST',
      headers:{'X-CSRF-TOKEN':CSRF,'Content-Type':'application/json','Accept':'application/json'},
      body: JSON.stringify(payload),
    });
    const data = await res.json();
    if (res.ok && data.success) {
      document.getElementById('checkout-modal').classList.remove('open');
      document.getElementById('success-modal').classList.add('open');
      updateCartUI({});
      ['f-fname','f-lname','f-phone','f-email','f-address','f-notes','f-facebook','f-instagram'].forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
      document.querySelectorAll('input[name="order_type"]').forEach(r => r.checked = false);
      document.getElementById('delivery-fields').style.display = 'none';
      selectedApp = '';
    } else if (res.status === 422 && data.errors) {
      Object.entries(data.errors).forEach(([field, msgs]) => {
        const el = document.getElementById('err-'+field);
        if (el) el.textContent = msgs[0];
      });
    } else {
      showToast(data.message || 'Something went wrong. Try again.');
    }
  } catch(e) {
    showToast('Network error. Please try again.');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Place Order 🍪';
  }
}

// ── MENU FILTER ──
function filterMenu(cat, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.product-card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
  });
}

// ── MOBILE MENU ──
function toggleMobile() { document.getElementById('mobile-menu').classList.toggle('open'); }

// ── TOAST ──
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2500);
}

// ── REVEAL ──
const revealObs = new IntersectionObserver(entries => {
  entries.forEach((e,i) => { if (e.isIntersecting) { setTimeout(() => e.target.classList.add('visible'), i*80); revealObs.unobserve(e.target); } });
}, {threshold:0.1});
document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

// ── INIT CART FROM SESSION ──
(async () => {
  const res = await fetch('{{ route("cart.get") }}');
  const data = await res.json();
  updateCartUI(data.cart);
})();
</script>
@endpush

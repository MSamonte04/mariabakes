<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'MariaBakes – Homemade by Ching')</title>
  <meta name="description" content="Homemade cookies, brownies, and cookie cakes by Ching. Order now!">
  <link rel="icon" type="image/png" href="{{ asset('images/mariabakes-logo.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
  @if(env('RECAPTCHA_SITE_KEY'))
  <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>
  @endif
</head>
<body class="overflow-x-hidden">

<!-- NAVBAR -->
<nav id="navbar">
  <a href="{{ route('home') }}#hero" class="nav-logo">
    <div class="nav-logo-img">
      <img src="{{ asset('images/mariabakes-logo.png') }}" alt="MariaBakes" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
      <div class="logo-fallback">🍪</div>
    </div>
    <div class="nav-logo-text"><span>Maria</span>Bakes</div>
  </a>
  <div class="nav-links" id="nav-links">
    <a href="#menu">Menu</a>
    <a href="#gallery">Gallery</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
  </div>
  <button class="nav-cart" id="cart-btn" onclick="openCart()">
    🛒 Cart
    <span class="cart-badge" id="cart-count" style="display:none">0</span>
  </button>
  <button class="hamburger" id="hamburger" onclick="toggleMobile()" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobile-menu">
  <a href="#menu" onclick="toggleMobile()">Menu</a>
  <a href="#gallery" onclick="toggleMobile()">Gallery</a>
  <a href="#about" onclick="toggleMobile()">About</a>
  <a href="#contact" onclick="toggleMobile()">Contact</a>
</div>

@yield('content')

<!-- FOOTER -->
<footer>
  <div>
    <div class="footer-logo"><span>Maria</span>Bakes</div>
    <div class="footer-sub">Homemade by Ching · Dasmarinas, Cavite</div>
  </div>
  <div class="footer-copy">© {{ date('Y') }} MariaBakes. Made with 🍪 and love.</div>
</footer>

<!-- CART DRAWER -->
<div class="cart-overlay" id="cart-overlay" onclick="closeCart()"></div>
<div class="cart-drawer" id="cart-drawer">
  <div class="cart-head">
    <h3>Your Cart 🛒</h3>
    <button class="cart-close" onclick="closeCart()">✕</button>
  </div>
  <div class="cart-items" id="cart-items-list"></div>
  <div class="cart-foot">
    <div class="cart-total-row">
      <span class="cart-total-label">Total</span>
      <span class="cart-total-amount" id="cart-total">₱0</span>
    </div>
    <button class="checkout-btn" id="checkout-btn" onclick="openCheckout()" disabled>Proceed to Checkout →</button>
  </div>
</div>

<!-- CHECKOUT MODAL -->
<div class="modal-overlay" id="checkout-modal">
  <div class="modal">
    <h2 class="modal-title">Your Order 🍪</h2>
    <p class="modal-sub">Fill in your details and we'll confirm your order shortly.</p>
    <div class="order-summary" id="checkout-summary"></div>
    {{-- Honeypot --}}
    <input type="text" name="website" style="display:none;position:absolute;left:-9999px;" tabindex="-1" autocomplete="off" id="hp-website">
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">First Name *</label>
        <input class="form-input" id="f-fname" type="text" placeholder="Maria">
        <span class="field-error" id="err-first_name"></span>
      </div>
      <div class="form-group">
        <label class="form-label">Last Name *</label>
        <input class="form-input" id="f-lname" type="text" placeholder="Santos">
        <span class="field-error" id="err-last_name"></span>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Contact Number *</label>
      <input class="form-input" id="f-phone" type="tel" placeholder="09XX XXX XXXX">
      <span class="field-error" id="err-phone"></span>
    </div>
    <div class="form-group">
      <label class="form-label">Email Address *</label>
      <input class="form-input" id="f-email" type="email" placeholder="maria@email.com">
      <span class="field-error" id="err-email"></span>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Facebook Name <span style="font-weight:400;font-size:11px">(optional)</span></label>
        <input class="form-input" id="f-facebook" type="text" placeholder="e.g. Maria Santos">
      </div>
      <div class="form-group">
        <label class="form-label">Instagram Handle <span style="font-weight:400;font-size:11px">(optional)</span></label>
        <input class="form-input" id="f-instagram" type="text" placeholder="e.g. @mariasantos">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Order Type *</label>
      <div class="radio-group">
        <label class="radio-option" onclick="onOrderType('pickup')">
          <input type="radio" name="order_type" value="pickup">
          <span><div class="radio-label">🏠 Pickup</div><div class="radio-hint">Pick up at our location in Dasmarinas, Cavite</div></span>
        </label>
        <label class="radio-option" onclick="onOrderType('delivery')">
          <input type="radio" name="order_type" value="delivery">
          <span><div class="radio-label">🚚 Delivery</div><div class="radio-hint">Via Lalamove, Grab Express, or Maxim</div></span>
        </label>
      </div>
      <span class="field-error" id="err-order_type"></span>
    </div>
    <div id="delivery-fields" style="display:none">
      <div class="form-group">
        <label class="form-label">Delivery Address *</label>
        <input class="form-input" id="f-address" type="text" placeholder="Full address for delivery">
        <span class="field-error" id="err-address"></span>
      </div>
      <div class="form-group">
        <label class="form-label">Delivery App *</label>
        <div class="app-grid" id="app-options">
          <div class="app-option" onclick="selectApp('Lalamove',this)"><span class="app-icon">🟠</span>Lalamove</div>
          <div class="app-option" onclick="selectApp('Grab Express',this)"><span class="app-icon">🟢</span>Grab Express</div>
          <div class="app-option" onclick="selectApp('Maxim',this)"><span class="app-icon">🔵</span>Maxim</div>
        </div>
        <span class="field-error" id="err-delivery_app"></span>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Special Notes (optional)</label>
      <textarea class="form-input" id="f-notes" rows="2" placeholder="Allergies, custom messages, etc."></textarea>
    </div>
    <div class="modal-footer">
      <button class="modal-back" onclick="closeCheckout()">← Back</button>
      <button class="modal-submit" id="submit-btn" onclick="submitOrder()">Place Order 🍪</button>
    </div>
  </div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal-overlay" id="success-modal">
  <div class="modal" style="text-align:center;padding:48px 40px">
    <div style="font-size:64px;margin-bottom:20px;animation:pop .5s cubic-bezier(.4,0,.2,1)">🎉</div>
    <h2 class="modal-title">Order Received!</h2>
    <p style="font-size:15px;color:rgba(61,31,15,0.6);line-height:1.75;margin:12px 0 28px">
      Thank you! We've received your order and will message you to confirm details and payment. See you soon! 🍪
    </p>
    <button class="btn-primary" onclick="closeSuccess()" style="margin:0 auto">Back to Menu →</button>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

@stack('scripts')
</body>
</html>

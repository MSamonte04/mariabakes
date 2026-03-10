<?php

namespace App\Http\Controllers;

use App\Mail\OrderAdminMail;
use App\Mail\OrderCustomerMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ShopController extends Controller
{
    // ─── HOMEPAGE ───
    public function index()
    {
        $products = Product::where('available', true)->orderBy('sort_order')->orderBy('category')->get();
        return view('home', compact('products'));
    }

    // ─── GET CART (JSON) ───
    public function cart(): JsonResponse
    {
        return response()->json([
            'cart'  => session('cart', []),
            'total' => $this->cartTotal(),
            'count' => $this->cartCount(),
        ]);
    }

    // ─── ADD TO CART ───
    public function addToCart(Request $request): JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::findOrFail($request->product_id);

        if (!$product->available) {
            return response()->json(['success' => false, 'message' => 'This item is currently unavailable.'], 422);
        }

        $cart = session('cart', []);
        $id   = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float) $product->price,
                'unit'  => $product->unit,
                'image' => $product->image_url,
                'qty'   => 1,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => $product->name . ' added to cart!',
            'cart'    => $cart,
            'total'   => $this->cartTotal(),
            'count'   => $this->cartCount(),
        ]);
    }

    // ─── UPDATE QTY ───
    public function updateCart(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required',
            'qty'        => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);
        $id   = $request->product_id;

        if ($request->qty <= 0) {
            unset($cart[$id]);
        } elseif (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cart'    => $cart,
            'total'   => $this->cartTotal(),
            'count'   => $this->cartCount(),
        ]);
    }

    // ─── REMOVE FROM CART ───
    public function removeFromCart(Request $request): JsonResponse
    {
        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cart'    => $cart,
            'total'   => $this->cartTotal(),
            'count'   => $this->cartCount(),
        ]);
    }

    // ─── PLACE ORDER ───
    public function placeOrder(Request $request): JsonResponse
    {
        // Rate limit: 3 orders per IP per hour
        if (RateLimiter::tooManyAttempts('order:' . $request->ip(), 3)) {
            return response()->json(['success' => false, 'message' => 'Too many requests. Please wait before trying again.'], 429);
        }
        RateLimiter::hit('order:' . $request->ip(), 3600);

        // Honeypot
        if ($request->filled('website')) {
            return response()->json(['success' => true, 'message' => 'Order placed!']);
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
        }

        // Validate
        $rules = [
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email|max:100',
            'order_type'     => 'required|in:pickup,delivery',
            'preferred_date' => 'required|string|max:30',
            'preferred_time' => 'required|string|max:30',
            'notes'          => 'nullable|string|max:500',
        ];
        if ($request->order_type === 'delivery') {
            $rules['address']      = 'required|string|max:255';
            $rules['delivery_app'] = 'required|string|max:50';
        }

        $validated = $request->validate($rules);

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        // Create order
        $order = Order::create([
            ...$validated,
            'order_number'   => Order::generateOrderNumber(),
            'address'        => $request->address ?? null,
            'delivery_app'   => $request->delivery_app ?? null,
            'total'          => $total,
            'status'         => 'pending',
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_name'  => $item['name'],
                'product_price' => $item['price'],
                'quantity'      => $item['qty'],
                'subtotal'      => $item['price'] * $item['qty'],
            ]);
        }

        // Send emails
        try {
            Mail::to(env('ADMIN_EMAIL'))->send(new OrderAdminMail($order));
        } catch (\Exception $e) {
            Log::error('Admin email failed: ' . $e->getMessage());
        }
        try {
            Mail::to($order->email)->send(new OrderCustomerMail($order));
        } catch (\Exception $e) {
            Log::error('Customer email failed: ' . $e->getMessage());
        }

        // Clear cart
        session()->forget('cart');

        return response()->json([
            'success'      => true,
            'order_number' => $order->order_number,
            'message'      => "Thank you, {$order->first_name}! Your order {$order->order_number} has been received. Check your email for confirmation!",
        ], 201);
    }

    // ─── HELPERS ───
    private function cartTotal(): float
    {
        return collect(session('cart', []))->sum(fn($i) => $i['price'] * $i['qty']);
    }

    private function cartCount(): int
    {
        return collect(session('cart', []))->sum(fn($i) => $i['qty']);
    }
}

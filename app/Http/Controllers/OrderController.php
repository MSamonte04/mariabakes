<?php
namespace App\Http\Controllers;
use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Rate limit: max 3 orders per IP per hour
        if (RateLimiter::tooManyAttempts('order:'.$request->ip(), 3)) {
            return response()->json(['success'=>false,'message'=>'Too many requests. Please wait before trying again.'], 429);
        }
        RateLimiter::hit('order:'.$request->ip(), 3600);

        // Honeypot
        if ($request->filled('website')) {
            return response()->json(['success'=>true,'message'=>'Order placed!']);
        }

        // reCAPTCHA v3 — only in production
        if (app()->environment('production')) {
            $recaptchaRes = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->recaptcha_token,
                'remoteip' => $request->ip(),
            ]);
            $score = $recaptchaRes->json()['score'] ?? 0;
            if ($score < 0.5) {
                return response()->json(['success'=>false,'message'=>'Spam detected. Please try again.'], 422);
            }
        }

        // Validate
        $rules = [
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|max:100',
            'facebook'     => 'nullable|string|max:100',
            'instagram'    => 'nullable|string|max:100',
            'order_type'   => 'required|in:pickup,delivery',
            'notes'        => 'nullable|string|max:500',
        ];
        if ($request->order_type === 'delivery') {
            $rules['address']      = 'required|string|max:300';
            $rules['delivery_app'] = 'required|in:Lalamove,Grab Express,Maxim';
        }
        $validated = $request->validate($rules);

        // Get cart
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success'=>false,'message'=>'Your cart is empty.'], 422);
        }

        $items = array_values(array_map(fn($i) => [
            'name'  => $i['name'],
            'qty'   => $i['qty'],
            'price' => $i['price'],
            'emoji' => $i['emoji'],
        ], $cart));
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $items));

        // Save order
        $order = Order::create([
            ...$validated,
            'address'      => $validated['address'] ?? null,
            'delivery_app' => $validated['delivery_app'] ?? null,
            'items'        => $items,
            'total'        => $total,
            'status'       => 'pending',
        ]);

        // Send email to admin
        try {
            Mail::to(env('ADMIN_EMAIL', 'admin@mariabakes.com'))
                ->send(new NewOrderMail($order));
        } catch (\Exception $e) {
            Log::error('Order email failed: '.$e->getMessage(), ['order_id'=>$order->id]);
        }

        // Clear cart
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => "Thanks, {$order->first_name}! Your order has been received. We'll reach out to confirm details shortly. 🍪",
        ], 201);
    }
}

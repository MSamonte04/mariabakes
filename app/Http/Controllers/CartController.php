<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    // All products — edit prices/names here
    public static function products(): array {
        return [
            ['id'=>1,'name'=>'Classic Chocolate Chip','category'=>'cookies','price'=>65,'unit'=>'per pc','emoji'=>'🍪','tag'=>'Bestseller','desc'=>'Golden edges, gooey center, loaded with chocolate chips.','available'=>true],
            ['id'=>2,'name'=>"S'mores Cookie",'category'=>'cookies','price'=>75,'unit'=>'per pc','emoji'=>'🔥','tag'=>'Fan Favorite','desc'=>'Graham cracker dough, marshmallow, and a Hershey square on top.','available'=>true],
            ['id'=>3,'name'=>'Red Velvet Brownie','category'=>'brownies','price'=>80,'unit'=>'per pc','emoji'=>'❤️','tag'=>'Special','desc'=>'Rich red velvet base with a cream cheese swirl. Fudgy perfection.','available'=>true],
            ['id'=>4,'name'=>'Classic Fudge Brownie','category'=>'brownies','price'=>70,'unit'=>'per pc','emoji'=>'🍫','tag'=>'Classic','desc'=>'Dense, fudgy, intensely chocolatey. The OG brownie.','available'=>true],
            ['id'=>5,'name'=>'Cookie Cake – 6"','category'=>'cookie-cakes','price'=>650,'unit'=>'whole','emoji'=>'🎂','tag'=>'Custom','desc'=>'Giant cookie cake with rosette piping. Perfect for celebrations.','available'=>true],
            ['id'=>6,'name'=>'Cookie Cake – 8"','category'=>'cookie-cakes','price'=>850,'unit'=>'whole','emoji'=>'🎂','tag'=>'Custom','desc'=>'Our biggest cookie cake, customizable message on top.','available'=>true],
            ['id'=>7,'name'=>'Mixed Box (6 pcs)','category'=>'boxes','price'=>380,'unit'=>'per box','emoji'=>'🎁','tag'=>'Gift Box','desc'=>'6 assorted cookies/brownies beautifully packaged with ribbon.','available'=>true],
            ['id'=>8,'name'=>'Mixed Box (12 pcs)','category'=>'boxes','price'=>720,'unit'=>'per box','emoji'=>'🎁','tag'=>'Gift Box','desc'=>'12 assorted treats — perfect for pasalubong or gifts!','available'=>true],
        ];
    }

    public function add(Request $request): JsonResponse {
        $request->validate(['product_id' => 'required|integer']);
        $products = collect(self::products());
        $product = $products->firstWhere('id', $request->product_id);
        if (!$product || !$product['available']) {
            return response()->json(['success'=>false,'message'=>'Product not available.'], 422);
        }
        $cart = session()->get('cart', []);
        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['qty']++;
        } else {
            $cart[$product['id']] = array_merge($product, ['qty'=>1]);
        }
        session()->put('cart', $cart);
        return response()->json(['success'=>true,'cart'=>$cart,'count'=>array_sum(array_column($cart,'qty'))]);
    }

    public function remove(Request $request): JsonResponse {
        $request->validate(['product_id' => 'required|integer']);
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);
        return response()->json(['success'=>true,'cart'=>$cart,'count'=>array_sum(array_column($cart,'qty'))]);
    }

    public function update(Request $request): JsonResponse {
        $request->validate(['product_id'=>'required|integer','qty'=>'required|integer|min:0']);
        $cart = session()->get('cart', []);
        if ($request->qty <= 0) {
            unset($cart[$request->product_id]);
        } else {
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['qty'] = $request->qty;
            }
        }
        session()->put('cart', $cart);
        return response()->json(['success'=>true,'cart'=>$cart,'count'=>array_sum(array_column($cart,'qty'))]);
    }

    public function get(): JsonResponse {
        $cart = session()->get('cart', []);
        return response()->json(['cart'=>$cart,'count'=>array_sum(array_column($cart,'qty'))]);
    }

    public function clear(): JsonResponse {
        session()->forget('cart');
        return response()->json(['success'=>true]);
    }
}

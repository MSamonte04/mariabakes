<?php
namespace App\Http\Controllers;
use App\Http\Controllers\CartController;

class HomeController extends Controller
{
    public function index()
    {
        $products = CartController::products();
        $cart     = session()->get('cart', []);
        return view('home', compact('products', 'cart'));
    }
}

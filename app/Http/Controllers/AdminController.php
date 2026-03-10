<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::latest();
        if ($s = $request->search) {
            $query->where(fn($q) => $q->where('first_name','like',"%$s%")->orWhere('last_name','like',"%$s%")->orWhere('email','like',"%$s%")->orWhere('phone','like',"%$s%"));
        }
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $orders    = $query->paginate(20)->withQueryString();
        $totalNew  = Order::where('status','pending')->count();
        $totalAll  = Order::count();
        $totalSales = Order::where('status','completed')->sum('total');
        return view('admin.dashboard', compact('orders','totalNew','totalAll','totalSales','request'));
    }

    public function show(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update(['status'=>'confirmed']);
        }
        return view('admin.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status'=>'required|in:pending,confirmed,ready,completed,cancelled']);
        $order->update(['status'=>$request->status]);
        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Order deleted.');
    }
}

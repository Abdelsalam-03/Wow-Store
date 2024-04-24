<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index()
    {
        $orders = Auth::user()->orders;
        $orderProducts = DB::table('order_products')
        ->join('products', 'products.id', '=', 'order_products.product_id')
        ->select('order_products.*', 'products.name')
        ->whereIn('order_products.order_id', function($query){
            $query->select('id')->from('orders')->where('user_id', '=', Auth::id());
        })
        ->get();
        return view('orders', ['orders' => $orders, 'orderProducts' => $orderProducts]);
    }

    function delete(Request $request)
    {
        $order = Order::findOrFail($request->order);
        if (Auth::id() == $order->user_id || Auth::user()->role == 'admin') {
            $order->status = 'canceled';
            $order->save();
            return redirect()->back()->with('success', 'Order Canceled');
        } else {
            return redirect()->back();
        }
    }

}

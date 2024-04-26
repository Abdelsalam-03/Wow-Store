<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index()
    {
        $orders = Order::select()
            ->where('user_id', '=', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
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
        if ($order->status == 'pending') {
            $order->status = 'canceled';
        } else {
            $products = $order->products;
            foreach ($products as $product) {
                $stock = Product::find($product->product_id);
                $stock->stock = $stock->stock + $product->quantity;
                $stock->save();
            }
        }
        $order->save();

        return redirect()->back()->with('success', 'Order Canceled');

    }

}

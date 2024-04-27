<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    
    public function index(Request $request)
    {
        $orders = Order::filter($request)
                    ->paginate(5);
        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $orderProducts = DB::table('order_products')
        ->join('products', 'products.id', '=', 'order_products.product_id')
        ->select('order_products.*', 'products.name', 'products.stock', 'products.price as actual_price')
        ->where('order_products.order_id', '=', $order->id)
        ->get();
        return view('admin.orders.show', ['order' => $order, 'orderProducts' => $orderProducts]);
    }

    public function cancel(string $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'pending') {
            $order->status = 'canceled';
        } else {
            $products = $order->products;
            foreach ($products as $product) {
                $stock = Product::find($product->product_id);
                $stock->stock = $stock->stock + $product->quantity;
                $stock->save();
            }
            $order->status = 'canceled';
        }
        $order->save();

        return redirect()->back()->with('success', 'Order Canceled');

    }

    public function process(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'processing';
        $order->save();

        $products = $order->products;

        foreach ($products as $product) {
            $stock = Product::find($product->product_id);
            $stock->stock = $stock->stock - $product->quantity;
            $stock->save();
        }

        return redirect()->back()->with('success', 'Order Processed');
    }

    public function ship(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'shipped';
        $order->save();

        return redirect()->back()->with('success', 'Order Shipped');

    }

    public function arrive(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        return redirect()->back()->with('success', 'Order Delivered');

    }

    public function search(Request $request)
    {
        $order = Order::find($request->id);
        if ($order) {
            return redirect(route('admin.orders.show', ['order' => $order->id]));
        } else {
            return redirect()->back()->with('fail', 'Order Not Found');
        }
    }

}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function index(Request $request){
        return response()->json(['orders' => $orders = Order::filter($request)->get()]);
    }

    public function show(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message'=>'Not Found'], 400);
        }
        $orderProducts = DB::table('order_products')
        ->join('products', 'products.id', '=', 'order_products.product_id')
        ->select('order_products.*', 'products.name', 'products.stock', 'products.price as actual_price')
        ->where('order_products.order_id', '=', $order->id)
        ->get();
        return response()->json(['order' => $order, 'orderProducts' => $orderProducts]);
    }

    public function cancel(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Not Found'], 400);
        }
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

        return response()->json(['success' => 'Order Canceled']);

    }

    public function process(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Not Found'], 400);
        }
        $order->status = 'processing';
        $order->save();

        $products = $order->products;

        foreach ($products as $product) {
            $stock = Product::find($product->product_id);
            $stock->stock = $stock->stock - $product->quantity;
            $stock->save();
        }

        return response()->json(['success' => 'Processed']);
    
    }

    public function ship(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Not Found'], 400);
        }
        $order->status = 'shipped';
        $order->save();

        return response()->json(['success' => 'shipped']);
        
    }

    public function arrive(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Not Found'], 400);
        }
        $order->status = 'delivered';
        $order->save();

        
        return response()->json(['success' => 'Arrived']);
        

    }

}

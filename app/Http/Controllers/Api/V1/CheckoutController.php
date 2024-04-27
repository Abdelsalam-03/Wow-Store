<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    function checkout(){
        $address = Auth::user()->address;
        if (! $address) {
            return response()->json(['fail' => 'Please Fill The Address Fields']);
        }
        $settings = Settings::settings();
        $items = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->select('carts.product_id', 'carts.user_id', 'carts.quantity', 'products.name as name', 'products.price', 'products.stock')
        ->where('carts.user_id', '=', Auth::id())
        ->get();
        $totalPrice = 0;
        foreach ($items as $product) {
            if ($product->stock < $product->quantity) {
                return redirect()->back()->with('fail', 'There Is Product Out Of Stock.');
            }
            $totalPrice+= ($product->price * $product->quantity);
        }
        
        $addressAsLine = $address->district . ' - ' . $address->street . ' - ' . $address->building . '. contact - ' . $address->phone;

        $order = Order::create([
            'user_id' => Auth::id(),
            'shipping_cost' => $settings->shipping_cost,
            'total' => $totalPrice,
            'date' => time(),
            'status' => 'pending',
            'address' => $addressAsLine,
        ]);

        foreach ($items as $product) {
            Order_product::create([
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'quantity' => $product->quantity,
                'price' => $product->price,
            ]);
        }

        Cart::where('user_id', '=', Auth::id())->delete();

        return response()->json(['success' => 'Order Created Successfully']);

    }
}

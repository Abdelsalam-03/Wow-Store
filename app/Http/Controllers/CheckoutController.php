<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    function check(){
        $items = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->select('carts.product_id', 'carts.user_id', 'carts.quantity', 'products.name as name', 'products.price', 'products.stock')
        ->where('carts.user_id', '=', Auth::id())
        ->get();
        if (! count($items)) {
            return redirect(route('home'));
        }
        $address = Auth::user()->address;
        return view('checkout', ['items' => $items, 'address' => $address]);
    }

    function checkout(){
        $address = Auth::user()->address;
        if (! $address) {
            return redirect()->back()->with('fail', 'Please Fill The Address Fields');
        }
        $items = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->select('carts.product_id', 'carts.user_id', 'carts.quantity', 'products.name as name', 'products.price', 'products.stock')
        ->where('carts.user_id', '=', Auth::id())
        ->get();
        foreach ($items as $product) {
            if ($product->stock < $product->quantity) {
                return redirect()->back()->with('fail', 'There Is Product Out Of Stock.');
            }
        }
        
        $order = Order::create([
            'user_id' => 2,
            'total' => 5000,
            'date' => now(),
            'status' => 'pending',
            'address' => 'Cairo',
        ]);

    }

}

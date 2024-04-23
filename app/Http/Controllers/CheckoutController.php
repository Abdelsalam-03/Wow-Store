<?php

namespace App\Http\Controllers;

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
        $address = Auth::user()->address;
        return view('checkout', ['items' => $items, 'address' => $address]);
    }
}

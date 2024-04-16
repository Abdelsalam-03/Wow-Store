<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function add(REQUEST $request){
        $data = $request->all();
        $product = Product::find($data['productId']);
        // return response()->json(['message' => Auth::user()->id]);
        if ($product) {
            $productOnCart = Cart::where([
                ['product_id', '=', $product->id],
                ['user_id', '=', Auth::id()],
                ])
                ->get()
                ->first();
            if ($productOnCart) {
                $productOnCart->quantity = $productOnCart->quantity + 1; 
                $productOnCart->save();
                return response()->json([Auth::user()->cartContent]);
            } else {
                Cart::create(['product_id' => $product->id, 'user_id' => Auth::id(), 'quantity' => 1]);
                return response()->json([Auth::user()->cartContent]);
            }
        } else {
            return response()->json(['error' => 'Validation Error'], 400);
        }
    }
}

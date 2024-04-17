<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    function index(){
        return response()->json(Auth::user()->cartContent);
    }

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

    function remove(string $id){
        Cart::where('product_id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->delete();
        return response()->json(['message' => 'product Removed Successfully']);
    }

    function destroy(){
        Cart::where('user_id', '=', Auth::id())->delete();
        return response()->json(['message' => 'Cart Destroyed successfully']);
    }

}

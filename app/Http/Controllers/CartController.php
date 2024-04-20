<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    function all(){
        return response()->json(Auth::user()->cartContent);
    }

    function add(REQUEST $request){
        $data = $request->all();
        $product = Product::find($data['productId']);
        $quantity = $request->quantity ? intval($request->quantity) : 1; 
        if ($product) {
            $productOnCart = Cart::where([
                ['product_id', '=', $product->id],
                ['user_id', '=', Auth::id()],
                ])
                ->get()
                ->first();
            if ($productOnCart) {
                $productOnCart->quantity = $productOnCart->quantity + $quantity; 
                $productOnCart->save();
                if (isset($data['toHome'])) {
                    return redirect('/products');
                } else {
                    return response()->json([Auth::user()->cartContent]);
                }
            } else {
                Cart::create(['product_id' => $product->id, 'user_id' => Auth::id(), 'quantity' => $quantity]);
                if (isset($data['toHome'])) {
                    return redirect('/products');
                } else {
                    return response()->json([Auth::user()->cartContent]);
                }
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

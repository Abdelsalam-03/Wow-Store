<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function all()
    {
        return response()->json(Auth::user()->cartContent);
    }

    function add(REQUEST $request)
    {
        $data = $request->all();
        $product = Product::find($data['product_id']);
        $quantity = $request->quantity ? intval($request->quantity) : 1;
        if ($product) {
            if (+$product->stock < $quantity) {
                return response()->json(['message' => 'Quantity More Than the Stock'], 400);
            }
            $productOnCart = Cart::where('user_id', '=', Auth::id())
            ->where('product_id', '=', $product->id)
            ->get()
            ->first();
            if ($productOnCart) {
                if ($quantity > $product->stock) {
                    return response()->json(['message' => 'Quantity More Than the Stock'], 400);
                }
                $productOnCart->quantity = $quantity;
                $productOnCart->save();
                return response()->json(['message' => 'Product Added Successfully']);
            } else {
                Cart::create(['product_id' => $product->id, 'user_id' => Auth::id(), 'quantity' => $quantity]);
                return response()->json(['message' => 'Added Successfully']);
            }
        } else {
            return response()->json(['error' => 'Validation Error'], 400);
        }
    }

    function update(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);
        $product = Product::find($request->product);
        $quantity = $request->quantity;
        if ($product) {
            if ($product->stock < $quantity) {
                return response()->json(['message' => 'quantity more than stock']);
            }
            $productOnCart = Cart::where('user_id', '=', Auth::id())
            ->where('product_id', '=', $product->id)
            ->get()
            ->first();
            if ($productOnCart) {
                if (+$quantity > 1) {
                    $productOnCart->quantity = $quantity; 
                    $productOnCart->save();
                } else {
                    $productOnCart->delete();
                }
            }
        }
        return response()->json(['success' => 'Quantity Updated Successfully']);
    }

    function remove(string $id, Request $request)
    {
        Cart::where('product_id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->delete();
        return response()->json(['message' => 'Product Removed Successfully']);
    }

    function destroy()
    {
        Cart::where('user_id', '=', Auth::id())->delete();
        return response()->json(['success' => 'Deleted Successfully']);
    }

}

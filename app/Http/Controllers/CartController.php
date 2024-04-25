<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    function index()
    {
        return view('cart', ['content' => DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->select('carts.product_id', 'carts.user_id', 'carts.quantity', 'products.name as name', 'products.price', 'products.photo', 'products.stock')
        ->where('carts.user_id', '=', Auth::id())
        ->get()]);
    }

    function all()
    {
        return response()->json(Auth::user()->cartContent);
    }

    function add(REQUEST $request)
    {
        $data = $request->all();
        $product = Product::find($data['productId']);
        $quantity = $request->quantity ? intval($request->quantity) : 1;
        if ($product) {
            if (+$product->stock < $quantity) {
                if (isset($data['return-to-home'])) {
                    return redirect()->back()->with('fail', 'Quantity More Than the Stock');
                } else {
                    return response()->json(['message' => 'Quantity More Than the Stock'], 400);
                }
            }
            $productOnCart = Cart::where('user_id', '=', Auth::id())
            ->where('product_id', '=', $product->id)
            ->get()
            ->first();
            if ($productOnCart) {
                if ($quantity > $product->stock) {
                    if (isset($data['return-to-home'])) {
                        return redirect()->back()->with('fail', 'Quantity More Than the Stock');
                    } else {
                        return response()->json(['message' => 'Quantity More Than the Stock'], 400);
                    }
                }
                $productOnCart->quantity = $quantity;
                $productOnCart->save();
                if (isset($data['return-to-home'])) {
                    return redirect(route('home'))->with('success', 'Product Added Successfully');
                } else {
                    return response()->json(['message' => 'Product Added Successfully']);
                }
            } else {
                Cart::create(['product_id' => $product->id, 'user_id' => Auth::id(), 'quantity' => $quantity]);
                if (isset($data['return-to-home'])) {
                    return redirect(route('home'))->with('success', 'Added Successfully');
                } else {
                    return response()->json(['message' => 'Added Successfully']);
                }
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
                return redirect(route('cart'));
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
        return redirect(route('cart'));
    }

    function remove(string $id, Request $request)
    {
        Cart::where('product_id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->delete();
        if ($request->response) {
            return response()->json(['message' => 'Product Removed Successfully']);
        } else {
            return redirect(route('cart'));
        }
    }

    function destroy()
    {
        Cart::where('user_id', '=', Auth::id())->delete();
        return redirect(route('cart'));
    }

}

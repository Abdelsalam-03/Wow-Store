<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function all(){
        $products = Product::select()->where('stock', '>', '0')->get();
        return response()->json(['products' => $products]);
    }

    function show(Request $request){
        $product = Product::find($request->product);
        if($product->id){
            return response()->json(['product' => $product]);
        } else {
            return response()->json(['message' => 'Product Not Found'], 400);
        }
    }
}

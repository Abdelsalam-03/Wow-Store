<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function show(Request $request){
        $product = Product::findOrFail($request->product);
        $request->merge([
            'query' => $product->name,
            'onStock' => true,
        ]);
        return view('user.products.show', [
            'product' => $product,
            'relatedProducts' => Product::filter($request)->get(),
            'settings' => Settings::settings(),
        ]);
    }
}

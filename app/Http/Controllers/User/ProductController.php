<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request){
        if ($request->query('query')) {
            $query = $request->query('query');
            $products = Product::where('name', 'like', "%$query%")
                                ->get();
            return view('user.products.index', ['products' => $products]);
        }else {
            return view('user.products.index', ['products' => Product::all()]);
        }
    }

    function show(Request $request){
        return view('user.products.show', ['product' => Product::findOrFail($request->product)]);
    }

}

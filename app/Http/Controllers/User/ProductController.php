<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(){
        return view('user.products.index', ['products' => Product::all()]);
    }

    function show(Request $request){
        return view('user.products.show', ['product' => Product::findOrFail($request->product)]);
    }

}

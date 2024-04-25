<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Settings;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function show(Request $request){
        return view('user.products.show', [
            'product' => Product::findOrFail($request->product),
            'settings' => Settings::settings(),
        ]);
    }

}

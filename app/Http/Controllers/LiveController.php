<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    function liveSearch(Request $request)
    {
        if ($request->query('query')) {
            return response()->json(Product::filter($request)->paginate(10));
        }
    }
}

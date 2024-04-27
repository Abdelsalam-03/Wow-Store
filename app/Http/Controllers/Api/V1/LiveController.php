<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class LiveController extends Controller
{
    function liveSearch(Request $request)
    {
        if ($request->query('query')) {
            return response()->json(Product::filter($request)->get());
        }
    }
}

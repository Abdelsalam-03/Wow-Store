<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(['products' => Product::filter($request)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'photo' => ['required'],
            'description' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $name = 'products/' . time() . uniqid() . '.' . $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        Storage::put('public/' . $name, $image_base64);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category,
            'stock' => $request->stock,
            'photo' => $name,
            'description' => $request->description,
        ]);
        return response()->json(['success' => 'Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'photo' => ['required'],
            'description' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message', 'Product not found.'], 400);
        }

        if ($request->photo != 'old') {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $name = 'products/' . time() . uniqid() . '.' . $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            Storage::put('public/' . $name, $image_base64);
            Storage::delete('public/' . $product->photo);
            $product->photo = $name;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->save();
        
        return response()->json(['success' => 'Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product){
            Storage::delete('public/' . $product->photo);
            $product->delete();
            return response()->json(['success' => 'Product Deleted']);
        } else {
            return response()->json(['message' => 'Product not found'], 400);
        }
    }
}

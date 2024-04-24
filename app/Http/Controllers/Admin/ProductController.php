<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.products.index', ['products' => Product::filter($request)->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'photo' => ['required'],
            'description' => ['required'],
        ]);

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
        if (isset($request->return)) {
            return redirect(route('admin.products.create'))->with('success', 'Product Created Successfully');
        } else {
            return redirect(route('admin.products.index'))->with('success', 'Product Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', [
            'product' => $product,
            'onCart' => $product->onCart,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.products.edit', ['product' => Product::findOrFail($id), 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'photo' => ['required'],
            'description' => ['required'],
        ]);

        $product = Product::findOrFail($id);

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
        return redirect(route('admin.products.index'))->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        Storage::delete('public/' . $product->photo);
        $product->delete();
        return redirect(route('admin.products.index'))->with('success', 'Product Deleted Successfully');
    }
}

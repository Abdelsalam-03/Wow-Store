<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'photo' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $name = 'categories/' . time() . uniqid() . '.' . $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        Storage::put('public/' . $name, $image_base64);

        Category::create([
            'name' => $request->name,
            'photo' => $name,
        ]);

        return response()->json(['message' => 'Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'category' => Category::find($id),
            'products' => Product::select()->where('category_id', '=', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category Not Found'], 400);
        }
        if ($category->name == $request->name) {
            $validator = Validator::make($request->all(), [
                'photo' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['message' => $errors], 400);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories',
                'photo' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['message' => $errors], 400);
            }
        }


        if ($request->photo != 'old') {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $name = 'categories/' . time() . uniqid() . '.' . $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            Storage::put('public/' . $name, $image_base64);
            if ($category->photo) {
                Storage::delete('public/' . $category->photo);
            }
            $category->photo = $name;
        }

        $category->save();
        return response()->json(['message' => 'Updated Successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return response()->json(['message' => 'Deleted Successfully']);
    }
}

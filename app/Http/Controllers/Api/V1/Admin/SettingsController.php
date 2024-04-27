<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    

    function set(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_cost' => ['required', 'numeric'],
            'stock_warning' => ['required', 'numeric'],
            'photo' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $name = 'default' . time() . uniqid() . '.' . $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        Storage::put('public/' . $name, $image_base64);

        $settings = new Settings();

        $settings->shipping_cost = $request->shipping_cost;
        $settings->stock_warning = $request->stock_warning;
        $settings->default_products_photo = $name;

        $settings->save();

        return response()->json(['success' => 'Settengs Setted Successfully']);
        
    }

    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_cost' => ['required', 'numeric'],
            'stock_warning' => ['required', 'numeric'],
            'photo' => ['required'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $settings = Settings::settings();

        if ($request->photo != 'old') {
            $image_parts = explode(";base64,", $request->photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $name = 'default' . time() . uniqid() . '.' . $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            Storage::put('public/' . $name, $image_base64);
            Storage::delete('public/' . $settings->default_products_photo);
            $settings->default_products_photo = $name;
        }
        
        $settings->shipping_cost = $request->shipping_cost;
        $settings->stock_warning = $request->stock_warning;
        $settings->save();

        return response()->json(['success' => 'Settengs Updated Successfully']);
    }

}

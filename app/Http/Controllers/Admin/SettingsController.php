<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    
    function view()
    {
        if (! Settings::setted()) {
            return view('admin.settings.create');
        } else {
            return view('admin.settings.settings', [
                'settings' => Settings::settings(),
            ]);
        }
    }

    function create()
    {
        if (! Settings::setted()) {
            return view('admin.settings.create');
        } else {
            return view('admin.settings.settings', [
                'settings' => Settings::settings(),
            ]);
        }
    }

    function set(Request $request)
    {
        $request->validate([
            'shipping_cost' => ['required', 'numeric'],
            'photo' => ['required'],
        ]);

        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $name = 'default' . time() . uniqid() . '.' . $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        Storage::put('public/' . $name, $image_base64);

        $settings = new Settings();

        $settings->shipping_cost = $request->shipping_cost;
        $settings->default_products_photo = $name;

        $settings->save();

        return redirect(route('admin.home'))->with('success', 'Settengs Setted Successfully');
        
    }

    function update(Request $request)
    {
        $request->validate([
            'shipping_cost' => ['required', 'numeric'],
            'photo' => ['required'],
        ]);

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
        $settings->save();

        return redirect(route('admin.settings'))->with('success', 'Settings Updated Successfully');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'district' => 'required',
            'street' => 'required',
            'building' => 'required',
            'phone' => 'required|numeric',
        ], [
            'district.required' => 'district:District is required.',
            'street.required' => 'street:Street is required.',
            'building.required' => 'building:Building is required.',
            'phone.required' => 'phone:Phone is required.',
            'phone.numeric' => 'phone:Phone is not Eligble.',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        } elseif (strlen($request->phone) != 11) {
            return response()->json(['message' => 'Phone Field is Too short'], 400);
        } else {
            $district = $request->district;
            $street = $request->street;
            $building = $request->building;
            $phone = $request->phone;
            $address = Auth::user()->address;
            if ($address) {
                $address->district = $district;
                $address->street = $street;
                $address->building = $building;
                $address->phone = $phone;
                $address->save();
                return response()->json(['message' => 'Address Updated Successfully']);
            } else {
                Address::create([
                    'district' => $district,
                    'street' => $street,
                    'building' => $building,
                    'phone' => $phone,
                    'user_id' => Auth::id(),
                ]);
                return response()->json(['message' => 'Address Saved Successfully']);
            }
        }

        

    }
}

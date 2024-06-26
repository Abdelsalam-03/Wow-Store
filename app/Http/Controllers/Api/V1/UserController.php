<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class UserController extends Controller
{

    function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('_token')->plainTextToken;

        event(new Registered($user));

        return response()->json(['_token' => $token]);
    }

    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $user = User::select()
                    ->where('email', '=', $request->email)
                    ->first();
        if (!$user) {
            return response()->json(['message' => "User Not Found"], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => "Password Not Correct"], 400);
        }

        $token = $user->createToken('_token')->plainTextToken;



        return response()->json(['_token' => $token]);
    }

    function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'logged out']);
    }

}

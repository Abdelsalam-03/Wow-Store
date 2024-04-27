<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::select()->where('role', '=', 'admin');
        if ($request->email) {
            $admins = $admins->where('email', 'like', '%' . $request->email . '%');
        }
        return response()->json([
            'admins' => $admins->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'exists:'.User::class],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors], 400);
        }

        $user = User::select()
                    ->where('email', '=', $request->email)
                    ->first();
        
        $user->role = 'admin';
        
        $user->save();

        return response()->json(['success' => 'Created Successully']);
    }

    public function suspend(Request $request)
    {
        $admin = User::find($request->admin);
        if (!$admin) {
            return response()->json(['message' => 'Not Found'], 400);
        }
        $admin->role = 'user';
        $admin->save();
        return response()->json(['success' => 'Created Successfully']);
    }

}

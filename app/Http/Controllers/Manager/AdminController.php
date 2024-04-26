<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = User::select()->where('role', '=', 'admin');
        if ($request->email) {
            $admins = $admins->where('email', 'like', '%' . $request->email . '%');
        }
        return view('manager.admins.index', [
            'admins' => $admins->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'exists:'.User::class],
        ]);

        $user = User::select()
                    ->where('email', '=', $request->email)
                    ->first();
        
        $user->role = 'admin';
        
        $user->save();

        return redirect(route('manager.admins.index'))->with('success', 'Created Successfully');
    }

    public function suspend(Request $request)
    {
        $admin = User::findOrFail($request->admin);
        $admin->role = 'user';
        $admin->save();
        return redirect(route('manager.admins.index'))->with('success', 'Suspended Successfully');
    }
}

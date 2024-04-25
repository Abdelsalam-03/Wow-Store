<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    function __invoke()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role  == 'admin' || $role  == 'manager') {
                return redirect(route('admin.home'));
            } elseif ($role  == 'user') {
                return redirect(route('home'));
            }
        } else {
            return redirect(route('home'));
        }
    }
}

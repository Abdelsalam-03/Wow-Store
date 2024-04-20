<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    function __invoke()
    {
        $role = Auth::user()->role;
        if ($role  == 'admin') {
            return redirect(route('admin.home'));
        } elseif ($role  == 'user') {
            return 'user home';
        }
    }
}

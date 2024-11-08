<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $auth_user = Auth::user();

        return view('admin.dashboard', compact('auth_user'));
    }
}

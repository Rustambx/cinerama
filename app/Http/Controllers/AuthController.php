<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($request->has('public')) {
            if (Auth::attempt($credentials)) {
                return redirect()->intended('/');
            }
        } else {
            if (Auth::attempt($credentials)) {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userRole = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $userRole->id
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->intended('/');
    }
}

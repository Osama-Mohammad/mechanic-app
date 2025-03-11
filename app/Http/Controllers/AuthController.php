<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        Auth::logout();

        if (Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            Auth::guard('customer')->user();
            return redirect('/');
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            Auth::guard('admin')->user();
            return redirect('/');
        }

        if (Auth::guard('mechanic')->attempt($request->only('email', 'password'))) {
            Auth::guard('mechanic')->user();
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('customer')->logout();
        Auth::guard('mechanic')->logout();
        Auth::logout();

        return back();
    }
}

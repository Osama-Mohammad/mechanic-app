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
            // return redirect('/');
            return redirect()->route('service-requests.index');
        } elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            Auth::guard('admin')->user();
            // return redirect('/');
            return redirect()->route('login.page');
        } elseif (Auth::guard('mechanic')->attempt($request->only('email', 'password'))) {
            Auth::guard('mechanic')->user();
            // return redirect('/');
            return redirect()->route('mechanic.emergency.show', Auth::guard('mechanic')->user());
        } else {
            return back()->with('error', 'Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('customer')->logout();
        Auth::guard('mechanic')->logout();
        Auth::logout();

        return redirect()->route('login.page');
        // return redirect('/');
    }
}

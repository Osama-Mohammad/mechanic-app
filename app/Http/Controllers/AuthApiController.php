<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);


        if ($validated) {
            if (Auth::guard('customer')->attempt($validated)) {
                Auth::guard('customer')->user();
                $token = Auth::guard('customer')->user()->createToken('CustomerToken', ['guard' => 'customer'])->plainTextToken;
                return response()->json([
                    'message' => 'Customer logged in successfully',
                    'customer' => Auth::guard('customer')->user(),
                    'token' => $token,
                    'role' => 'customer',
                    'status' => 200
                ]);
            } elseif (Auth::guard('admin')->attempt($validated)) {
                Auth::guard('admin')->user();
                $token = Auth::guard('admin')->user()->CreateToken('AdminToken', ['guard' => 'admin'])->plainTextToken;
                return response()->json([
                    'message' => 'Admin logged in successfully',
                    'admin' => Auth::guard('admin')->user(),
                    'token' => $token,
                    'role' => 'admin',
                    'status' => 200
                ]);
            } elseif (Auth::guard('mechanic')->attempt($validated)) {
                Auth::guard('mechanic')->user();
                $token = Auth::guard('mechanic')->user()->CreateToken('MechanicToken', ['guard' => 'mechanic'])->plainTextToken;
                return response()->json([
                    'message' => 'Mechanic logged in successfully',
                    'mechanic' => Auth::guard('mechanic')->user(),
                    'token' => $token,
                    'role' => 'mechanic',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid Credentials',
                    'status' => 401
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully',
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
}

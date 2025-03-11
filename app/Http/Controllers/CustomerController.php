<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create()
    {
        return view('Customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone|max:15',
            'location' => 'required|string|max:255',
            'email' => 'required|unique:customers,email|unique:mechanics,email|unique:admins,email|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $customer = new Customer();
        $customer->name = $validated['name'];
        $customer->phone = $validated['phone'];
        $customer->location = $validated['location'];
        $customer->email = $validated['email'];
        $password = bcrypt($validated['password']);
        $customer->password = $password;
        $customer->registration_date = now();

        $customer->save();

        // return response()->json(['msg' => 'Added Successfully', 'customer' => $customer]);
        return back();
    }
}

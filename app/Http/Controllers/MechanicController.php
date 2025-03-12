<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function RegisterPage()
    {
        return view('Mechanic.create');
    }

    public function RegisterStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email|unique:mechanics,email|unique:mechanics,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string|unique:customers,phone|max:15',
            'specialization' => 'required|min:5',
            'experience' => 'required|numeric',
            'availability' => 'required',
            'rating' => 'required|numeric'
        ]);

        $mechanic = new Mechanic();
        $mechanic->name = $validated['name'];
        $mechanic->email = $validated['email'];
        $password = bcrypt($validated['password']);
        $mechanic->password = $password;
        $mechanic->phone = $validated['phone'];
        $mechanic->specialization = $validated['specialization'];
        $mechanic->experience = $validated['experience'];
        $mechanic->availability = $validated['availability'];
        $mechanic->rating = $validated['rating'];
        $mechanic->save();

        return back();
    }

    public function ProfilePage(Mechanic $mechanic)
    {
        return view('Mechanic.profile', compact('mechanic'));
    }

    public function EditProfilePage(Mechanic $mechanic)
    {
        return view('Mechanic.edit', compact('mechanic'));
    }

    public function EditProfile(Mechanic $mechanic, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $mechanic->id,
            'email' => 'required|email|unique:customers,email|unique:admins,email|unique:mechanics,email,' . $mechanic->id,
            'experience' => 'required|numeric'
        ]);
        $mechanic->update($validated);
        return redirect()->route('mechanic_profilePage', compact('mechanic'));
    }
}

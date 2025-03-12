<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function RegisterPage()
    {
        return view('Admin.create');
    }

    public function RegisterStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email|unique:mechanics,email|unique:admins,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $admin = new Admin();
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $password = bcrypt($validated['password']);
        $admin->password = $password;
        $admin->save();
        return back();
    }

    public function ProfilePage(Admin $admin)
    {
        return view('Admin.profile', compact('admin'));
    }

    public function EditProfilePage(Admin $admin)
    {
        return view('Admin.edit', compact('admin'));
    }

    public function EditProfile(Admin $admin, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email|unique:mechanics,email|unique:admins,email,' . $admin->id,
        ]);
        $admin->update($validated);
        return redirect()->route('admin_profilePage', $admin);
    }
}

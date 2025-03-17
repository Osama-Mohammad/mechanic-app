<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function RegisterPage()
    {
        $cities = [
            "Beirut","Tripoli","Sidon","Tyre","Zahle","Jounieh","Baalbek","Byblos","Batroun","Nabatieh","Bcharré","Keserwan","Chouf","Marjeyoun","Aley","Metn","Baabda","Hermel","Rashaya","Jbeil"
                 ];
        return view('Mechanic.create',compact('cities'));
    }

    public function RegisterStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:customers,email|unique:mechanics,email|unique:mechanics,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'phone' => 'required|string|unique:customers,phone|max:15',
            'specialization' => 'required|min:5',
            'experience' => 'required|numeric',
            'location' => 'required'
        ]);

        $mechanic = new Mechanic();
        $mechanic->name = $validated['name'];
        $mechanic->email = $validated['email'];
        $password = bcrypt($validated['password']);
        $mechanic->password = $password;
        $mechanic->phone = $validated['phone'];
        $mechanic->specialization = $validated['specialization'];
        $mechanic->experience = $validated['experience'];
        $mechanic->location = $validated['location'];

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
            'experience' => 'required|numeric',
            'availability' => 'required',
        ]);
        $mechanic->update($validated);
        return redirect()->route('mechanic_profilePage', compact('mechanic'));
    }
}

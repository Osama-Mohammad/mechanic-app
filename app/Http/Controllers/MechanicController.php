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
            "Beirut",
            "Tripoli",
            "Sidon",
            "Tyre",
            "Zahle",
            "Jounieh",
            "Baalbek",
            "Byblos",
            "Batroun",
            "Nabatieh",
            "Bcharré",
            "Keserwan",
            "Chouf",
            "Marjeyoun",
            "Aley",
            "Metn",
            "Baabda",
            "Hermel",
            "Rashaya",
            "Jbeil"
        ];

        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
        return view('Mechanic.create', compact('cities', 'days'));
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
            'location' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'workdays' => 'required|array'
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
        $mechanic->longitude = $validated['longitude'];
        $mechanic->latitude = $validated['latitude'];
        $mechanic->start_time = $validated['start_time'];
        $mechanic->end_time = $validated['end_time'];
        $mechanic->workdays = json_encode($validated['workdays']);

        $mechanic->save();

        return redirect()->route('login.page');
    }

    public function ProfilePage(Mechanic $mechanic)
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
        $selected_days = json_decode($mechanic->workdays, true);
        return view('Mechanic.profile', compact('mechanic', 'selected_days', 'days'));
    }

    public function EditProfilePage(Mechanic $mechanic)
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
        $selected_days = json_decode($mechanic->workdays, true);
        return view('Mechanic.edit', compact('mechanic', 'selected_days', 'days'));
    }

    public function EditProfile(Mechanic $mechanic, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $mechanic->id,
            'email' => 'required|email|unique:customers,email|unique:admins,email|unique:mechanics,email,' . $mechanic->id,
            'experience' => 'required|numeric',
            'availability' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'workdays' => 'required|array'
        ]);
        $mechanic->update($validated);
        return redirect()->route('mechanic.profile', compact('mechanic'));
    }
}

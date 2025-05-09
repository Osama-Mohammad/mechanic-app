<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function create()
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
        return view('Customer.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone|max:15',
            'location' => 'required|string|max:255',
            'email' => 'required|unique:customers,email|unique:mechanics,email|unique:admins,email|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $customer = new Customer();
        $customer->name = $validated['name'];
        $customer->phone = $validated['phone'];
        $customer->location = $validated['location'];
        $customer->latitude = $validated['latitude'] ?? null;
        $customer->longitude = $validated['longitude'] ?? null;
        $customer->email = $validated['email'];
        $password = bcrypt($validated['password']);
        $customer->password = $password;
        $customer->registration_date = now();

        $customer->save();

        // return response()->json(['msg' => 'Added Successfully', 'customer' => $customer]);
        return  redirect()->route('login.page');
    }

    public function ProfilePage($id)
    {
        $customer = Customer::find($id);
        return view('Customer.profile', compact('customer'));
    }

    public function EditProfile($id)
    {
        $customer = Customer::find($id);
        return view('Customer.edit', compact('customer'));
    }

    public function UpdateProfile(Request $request, $id)
    {

        // dd($request);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $id,
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'email' => 'required|email|unique:customers,email,' . $id . '|unique:mechanics,email|unique:admins,email',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ]
        ]);

        if (isset($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $customer = Customer::find($id);
        $customer->update($validated);



        return redirect('/customer/profile/' . $customer->id);
    }
}

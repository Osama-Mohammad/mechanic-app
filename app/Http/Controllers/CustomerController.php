<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create()
    {
        $cities = [
            "Beirut","Tripoli","Sidon","Tyre","Zahle","Jounieh","Baalbek","Byblos","Batroun","Nabatieh","Bcharré","Keserwan","Chouf","Marjeyoun","Aley","Metn","Baabda","Hermel","Rashaya","Jbeil"
                 ];
        return view('Customer.create',compact('cities'));
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

    public function UpdateProfile($id)
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:customers,phone,' . $id,
            'location' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id . '|unique:mechanics,email|unique:admins,email',
        ]);
        $customer = Customer::find($id);
        $customer->update($validated);

        return redirect('/customer/profile/' . $customer->id);
    }
}

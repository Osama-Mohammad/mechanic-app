<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    /**
     * Display a listing of mechanics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanics = Mechanic::latest()->paginate(10);
        return view('admin.mechanics.index', compact('mechanics'));
    }

    /**
     * Display the specified mechanic.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function show(Mechanic $mechanic)
    {
        $mechanic->load(['serviceRequests', 'emergencyRequests', 'reviews']);
        return view('admin.mechanics.show', compact('mechanic'));
    }
}

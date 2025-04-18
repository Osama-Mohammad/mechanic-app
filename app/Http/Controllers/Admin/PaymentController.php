<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['customer', 'serviceRequest'])
            ->latest()
            ->paginate(10);
            
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payment->load(['customer', 'serviceRequest']);
        
        return view('admin.payments.show', compact('payment'));
    }
} 
<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\ServiceRequest;
use App\Notifications\PaymentSuccessful;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment) {}

    public function checkout(ServiceRequest $serviceRequestId)
    {
        $serviceRequest = ServiceRequest::with('serviceType')->findOrFail($serviceRequestId->id);

        // Check if the service request exists
        // $serviceRequest->load('serviceType');


        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Service Request Payment For : ' . $serviceRequest->serviceType->name,
                    ],
                    'unit_amount' => $serviceRequest->serviceType->price * 100, // in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'customer_id' => $serviceRequest->customer_id,
                'service_request_id' => $serviceRequest->id,
            ]
        ]);


        session(['request_id' => $serviceRequest->id]);


        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Check if the user is authenticated
        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve the session using the session ID from the request
        $session = Session::retrieve($request->get('session_id'));

        // Retrieve the service request ID from the session metadata
        $serviceRequestId = session('request_id');

        $payment = Payment::where('reference_id', $session->payment_intent)->first();


        /* !Payment::where('reference_id', $session->payment_intent)->exists() */

        // Check if the payment already exists
        if (!$payment) {
            $payment =   Payment::create([
                'amount' => $session->amount_total / 100,
                'method' => 'creditCard',
                'status' => 'success',
                'transaction_date' => now(),
                'customer_id' => Auth::guard('customer')->user()->id,
                'service_request_id' => $serviceRequestId,
                'reference_id' => $session->payment_intent,
            ]);
            // Update the service request status to 'paid'
            ServiceRequest::findOrFail($serviceRequestId)->update(['status' => 'paid']);

            Auth::guard('customer')->user()->notify(new PaymentSuccessful($payment->serviceRequest->mechanic->name, $payment->amount, $payment->serviceRequest->serviceType->name, $payment->transaction_date));
        }
        // Optionally, you can also update the service request status here
        return view('payments.success', compact('payment'));
    }

    public function cancel(ServiceRequest $serviceRequest)
    {
        return view('payments.cancel');
    }
}

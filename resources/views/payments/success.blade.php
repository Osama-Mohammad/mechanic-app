<x-layout>
    <x-nav />

    <style>
        /* Inherit all existing styles from your service requests page */
        .success-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .success-card {
            background-color: #343a40;
            border: 1px solid #454d55;
            border-radius: 0.25rem;
        }

        .success-header {
            background-color: #23272b;
            padding: 1.5rem;
            border-bottom: 1px solid #454d55;
            text-align: center;
        }

        .success-body {
            padding: 2rem;
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .payment-details {
            background-color: #3e444a;
            padding: 1.5rem;
            border-radius: 0.25rem;
            margin-top: 1.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #454d55;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #adb5bd;
        }

        .btn-continue {
            background-color: #ffc107;
            color: #212529;
            margin-top: 2rem;
            padding: 0.75rem 1.5rem;
        }

        .btn-continue:hover {
            background-color: #e0a800;
        }
    </style>

    <div class="container success-container">
        <div class="card success-card">
            <div class="success-header">
                <h3><i class="fas fa-check-circle success-icon"></i></h3>
                <h2 class="text-light">Payment Successful!</h2>
                <p class="text-muted">Thank you for your payment</p>
            </div>

            <div class="success-body text-center">
                <p class="text-light">Your payment has been processed successfully. Below are your payment details:</p>

                <div class="payment-details text-left">
                    <div class="detail-row">
                        <span class="detail-label">Reference Number:</span>
                        <span class="text-light">{{ $payment->reference_id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="text-light">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Payment Method:</span>
                        <span class="text-light">{{ ucfirst($payment->method) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date & Time:</span>
                        <span
                            class="text-light">{{ \Carbon\Carbon::parse($payment->transaction_date)->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Service Request:</span>
                        <span class="text-light">#{{ $payment->service_request_id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Mechanic:</span>
                        <span class="text-light">{{ $payment->serviceRequest->mechanic->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Service Type:</span>
                        <span class="text-light">{{ $payment->serviceRequest->serviceType->name }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-light">A confirmation has been sent to your email address.</p>
                    <a href="{{ route('service-requests.index', Auth::guard('customer')->user()->id) }}"
                        class="btn btn-continue">
                        <i class="fas fa-arrow-left mr-2"></i> Return to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>

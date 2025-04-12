<x-layout>
    <x-nav />

    <style>
        /* Inherit all existing styles from your service requests page */
        .cancelled-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .cancelled-card {
            background-color: #343a40;
            border: 1px solid #454d55;
            border-radius: 0.25rem;
        }

        .cancelled-header {
            background-color: #23272b;
            padding: 1.5rem;
            border-bottom: 1px solid #454d55;
            text-align: center;
        }

        .cancelled-body {
            padding: 2rem;
        }

        .cancelled-icon {
            font-size: 4rem;
            color: #dc3545;
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

        .btn-action {
            margin-top: 2rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .btn-retry {
            background-color: #ffc107;
            color: #212529;
            border: none;
        }

        .btn-retry:hover {
            background-color: #e0a800;
            color: #212529;
        }

        .btn-continue {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
        }

        .btn-continue:hover {
            background-color: #5a6268;
            color: #ffffff;
        }

        .support-message {
            color: #ffffff !important;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
    </style>

    <div class="container cancelled-container">
        <div class="card cancelled-card">
            <div class="cancelled-header">
                <h3><i class="fas fa-times-circle cancelled-icon"></i></h3>
                <h2 class="text-light">Payment Cancelled</h2>
                <p class="text-muted">Your payment was not completed</p>
            </div>

            <div class="cancelled-body text-center">
                <p class="text-light">The payment process was interrupted or cancelled. Your service request remains active.</p>

                @isset($payment)
                    <div class="payment-details text-left">
                        <div class="detail-row">
                            <span class="detail-label">Service Request:</span>
                            <span class="text-light">#{{ $payment->service_request_id ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Attempted Amount:</span>
                            <span class="text-light">${{ isset($payment->amount) ? number_format($payment->amount, 2) : 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="text-danger">Cancelled</span>
                        </div>
                    </div>
                @endisset

                <div class="mt-4 d-flex justify-content-center gap-3">
                    @isset($serviceRequestId)
                        <a href="{{ route('payment.checkout', $serviceRequestId) }}" class="btn btn-action btn-retry">
                            <i class="fas fa-redo-alt mr-2"></i> Retry Payment
                        </a>
                    @endisset

                    <a href="{{ route('service-requests.index', Auth::guard('customer')->user()->id) }}" class="btn btn-action btn-continue">
                        <i class="fas fa-arrow-left mr-2"></i> Return to Dashboard
                    </a>
                </div>

                <div class="support-message">
                    <small>If you continue to experience issues, please contact our support team.</small>
                </div>
            </div>
        </div>
    </div>
</x-layout>

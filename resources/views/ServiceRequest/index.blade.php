<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
        }

        /* Table styling */
        .table-container {
            margin-top: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #343a40;
            /* Dark background */
            color: #f8f9fa;
            /* Light text */
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #454d55;
            /* Light border for rows */
        }

        .table th {
            background-color: #23272b;
            /* Darker background for headers */
            color: #f8f9fa;
            /* Light text */
        }

        .table tr:hover {
            background-color: #3e444a;
            /* Hover effect for rows */
        }

        .btn-review {
            background-color: #ffc107;
            /* Yellow button */
            color: black;
            /* Dark text for contrast */
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-review:hover {
            background-color: #e0a800;
            /* Darker yellow on hover */
        }

        /* Card styling for consistency */
        .card {
            background-color: #343a40;
            /* Dark background */
            color: #f8f9fa;
            /* Light text */
            border: 1px solid #454d55;
            /* Light border */
        }

        .card-header {
            background-color: #23272b;
            /* Darker background */
            border-bottom: 1px solid #454d55;
            /* Light border */
            color: #f8f9fa;
            /* Light text */
        }

        .card-title {
            margin-bottom: 0;
        }

        /* Icon styling */
        .icon {
            margin-right: 8px;
            /* Space between icon and text */
        }
    </style>

    <div class="container mt-5">
        <div class="card bg-dark text-light">
            <div class="card-header bg-dark">
                <h3 class="card-title text-center">
                    <i class="fas fa-tools icon"></i> Service Requests for Customer:
                    {{ Auth::guard('customer')->user()->name }}
                </h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-wrench icon"></i>Service Type</th>
                                <th><i class="fas fa-info-circle icon"></i>Status</th>
                                <th><i class="fas fa-calendar-alt icon"></i>Appointment Time</th>
                                <th><i class="fas fa-user-cog icon"></i>Mechanic</th>
                                <th><i class="fas fa-comments icon"></i>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($serviceRequests as $serviceRequest)
                                <tr>
                                    <td>{{ $serviceRequest->serviceType->name }}</td>
                                    <td>{{ $serviceRequest->status }}</td>
                                    <td>{{ $serviceRequest->appointment_time }}</td>
                                    <td>{{ $serviceRequest->mechanic->name }}</td>
                                    <td>}
                                        <a href="{{ route('CreateReview', $serviceRequest) }}" class="btn btn-review">
                                            <i class="fas fa-comment-dots icon"></i> Leave a review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>

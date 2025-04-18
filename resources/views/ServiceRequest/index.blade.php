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
                            @forelse ($serviceRequests as $serviceRequest)
                                <tr id="regular-row-{{ $serviceRequest->id }}">
                                    <td>{{ $serviceRequest->serviceType->name }}</td>
                                    <td>{{ $serviceRequest->status }}</td>
                                    <td>{{ $serviceRequest->date }} At {{ $serviceRequest->time }}</td>
                                    <td>{{ $serviceRequest->mechanic->name }}</td>
                                    <td>
                                        @if ($serviceRequest->status != 'canceled')
                                            <a href="{{ route('reviews.create.specific', $serviceRequest) }}"
                                                class="btn btn-review">
                                                <i class="fas fa-comment-dots icon"></i> Leave a review
                                            </a>
                                            @if ($serviceRequest->status == 'completed' && !$serviceRequest->payment)
                                                <a href="{{ route('payment.checkout', $serviceRequest->id) }}"
                                                    class="btn btn-success">
                                                    Pay for Service
                                                </a>
                                            @endif
                                        @else
                                            <button class="btn btn-danger BtnDeleteRegularRequest"
                                                data-id="{{ $serviceRequest->id }}">
                                                <i class="fas fa-trash "></i>
                                                Delete Service Request
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <i class="fas fa-exclamation-circle icon"></i> No service requests found.
                                    </td>
                                </tr>
                            @endforelse
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



    <div class="container mt-5">
        <div class="card bg-dark text-light">
            <div class="card-header bg-dark">
                <h3 class="card-title text-center">
                    <i class="fas fa-tools icon"></i> Emergency Requests for Customer:
                    {{ Auth::guard('customer')->user()->name }}
                </h3>
            </div>
            <div class="card-body">
                <div class="table-container">

                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th><i class="fas fa-wrench icon"></i>Description</th>
                                <th><i class="fas fa-info-circle icon"></i>Location</th>
                                <th><i class="fas fa-calendar-alt icon"></i>Status</th>
                                <th><i class="fas fa-user-cog icon"></i>Response TIme</th>
                                <th><i class="fas fa-comments icon"></i>Mechanic</th>
                                <th><i class="fas fa-comments icon"></i>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($emergencyRequests as $emergencyRequest)
                                <tr id="emergency-row-{{ $emergencyRequest->id }}">
                                    <td>{{ $emergencyRequest->description }}</td>
                                    <td>{{ $emergencyRequest->location }}</td>
                                    <td>{{ $emergencyRequest->status }}</td>
                                    <td>{{ $emergencyRequest->response_time }}</td>
                                    <td>{{ $emergencyRequest->mechanic->name }}</td>
                                    <td>
                                        @if ($emergencyRequest->status == 'canceled')
                                            <button class="btn btn-danger BtnDeleteEmergencyRequest"
                                                data-id="{{ $emergencyRequest->id }}">
                                                <i class="fas fa-trash "></i>
                                                Delete Service Request
                                            </button>
                                        @endif
                                    </td>
                                </tr>


                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <i class="fas fa-exclamation-circle icon"></i> No canceled service requests
                                        found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>


                        {{-- @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif --}}
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $(document).on('click', '.BtnDeleteRegularRequest', function() {
                let id = $(this).data('id');

                if (!confirm(
                        "Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('customer.service.delete') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#regular-row-' + data.id).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });


            $(document).on('click', '.BtnDeleteEmergencyRequest', function() {
                let id = $(this).data('id');

                if (!confirm(
                        "Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('emergency.request.delete') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#emergency-row-' + data.id).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });
        });
    </script>
</x-layout>

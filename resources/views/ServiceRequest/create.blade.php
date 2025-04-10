<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: none;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            background-color: #343a40;
            color: white;
            border: 1px solid #454d55;
        }

        .form-control:focus {
            background-color: #343a40;
            color: white;
            border-color: #ffcc00;
            box-shadow: none;
        }

        .btn-warning {
            background-color: #ffcc00;
            border: none;
            color: #343a40;
            font-weight: bold;
        }

        .btn-warning:hover {
            background-color: #e6b800;
        }

        /* Ensure even spacing */
        .form-group {
            margin-bottom: 1.5rem;
            /* Consistent margin for all form groups */
        }

        .input-group {
            margin-bottom: 1.5rem;
            /* Consistent margin for input groups */
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-tools"></i> Service Request Form
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('service-requests.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="service_type_id" class="form-label">Service Type:</label>
                                <div class="input-group">
                                    <select name="service_type_id" id="service_type_id"
                                        class="form-control bg-dark text-light">
                                        @if ($mechanics->isNotEmpty())
                                            @foreach ($mechanics->first()->serviceTypes as $serviceType)
                                                <option value="{{ $serviceType->id }}">{{ $serviceType->name }} -
                                                    ${{ number_format($serviceType->price, 2) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="input-group-text bg-dark border-dark">
                                        <i class="fas fa-caret-down text-light"></i>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="date" class="form-label">Appointment Date:</label>
                                    <input type="date" name="date" id="date" class="form-control">
                                    @if (session('reserved'))
                                        <p class="text-warning mt-2">{{ session('reserved') }}</p>
                                        <div class="form-control bg-dark text-light p-3">
                                            <!-- Simple Days List -->
                                            <div class="mb-3">
                                                <p class="mb-2"><strong>Working Days:</strong></p>
                                                <p>{{ implode(', ', session('workdays', [])) }}
                                            </div>
                                            <!-- Simple Time Display -->
                                            <div>
                                                <p class="mb-2"><strong>Working Hours:</strong></p>
                                                <p>
                                                    {{ \Carbon\Carbon::parse(session('start_time'))->format('h:i A') }}
                                                    to
                                                    {{ \Carbon\Carbon::parse(session('end_time'))->format('h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <p class="text-warning mt-2">{{ session('error') }}</p>
                                        <div class="mb-4">
                                            <label class="form-label">
                                                <i class="fas fa-calendar-alt me-2"></i>Work Schedule:
                                            </label>
                                            <div class="form-control bg-dark text-light p-3">
                                                <!-- Simple Days List -->
                                                <div class="mb-3">
                                                    <p class="mb-2"><strong>Working Days:</strong></p>
                                                    {{-- {{ implode(', ', session('workdays', [])) here the ,[] means it defaults to empty array }} --}}
                                                    <>{{ implode(', ', session('workdays', [])) }}
                                                </div>
                                                <!-- Simple Time Display -->
                                                <div>
                                                    <p class="mb-2"><strong>Working Hours:</strong></p>
                                                    <p>
                                                        {{ \Carbon\Carbon::parse(session('start_time'))->format('h:i A') }}
                                                        to
                                                        {{ \Carbon\Carbon::parse(session('end_time'))->format('h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @error('time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="end_time" class="form-label">
                                        <i class="fas fa-clock"></i> Time:
                                    </label>
                                    <input type="time" id="time" name="time"
                                        class="form-control bg-dark text-light" required>
                                    @error('time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="mechanic_id" class="form-label">Mechanics:</label>
                                    <div class="input-group">
                                        <select name="mechanic_id" id="mechanic_id"
                                            class="form-control bg-dark text-light">
                                            @foreach ($mechanics as $mechanic)
                                                <option value="{{ $mechanic->id }}">
                                                    {{ $mechanic->name }}
                                                    - <span
                                                        class="rating">{{ number_format($mechanic->average_rating, 1) }}
                                                        ⭐</span>
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text bg-dark border-dark">
                                            <i class="fas fa-caret-down text-light"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-paper-plane"></i> Make Request
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <script>
        $(document).ready(function() {
            // Trigger change on initial load to populate service types for default mechanic
            $('#mechanic_id').trigger('change');

            $('#mechanic_id').on('change', function() {
                $('#service_type_id').html('<option value="">Loading services...</option>');
                let id = $(this).val();

                $.ajax({
                    url: '{{ route('customer.serviceType.Change') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#service_type_id').empty();
                        // Check if there are service types
                        if (response.ServiceTypes && response.ServiceTypes.length > 0) {
                            response.ServiceTypes.forEach(function(serviceType) {
                                let price = parseFloat(serviceType.price);
                                let formattedPrice = isNaN(price) ? '0.00' : price.toFixed(2);
                                $('#service_type_id').append(
                                    `<option value="${serviceType.id}">${serviceType.name} - $${formattedPrice}</option>`
                                );
                            });
                            console.log(response.ServiceTypes)

                        } else {
                            $('#service_type_id').append(
                                `<option value="">No services available for this mechanic</option>`
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-layout>

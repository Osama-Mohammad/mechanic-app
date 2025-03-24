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
                                    <select name="service_type_id" id="service_type_id" class="form-control bg-dark text-light">
                                        @foreach ($ServiceTypes as $ServiceType)
                                            <option value="{{ $ServiceType->id }}">{{ $ServiceType->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text bg-dark border-dark">
                                        <i class="fas fa-caret-down text-light"></i>
                                    </span>
                                </div>

                            <div class="form-group">
                                <label for="appointment_time" class="form-label">Appointment Date:</label>
                                <input type="date" name="appointment_time" id="appointment_time"
                                    class="form-control">
                                @if (session('reserved'))
                                    <p class="text-warning mt-2">Already has an appointment reserved. Please pick
                                        another date.</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="mechanic_id" class="form-label">Mechanics:</label>
                                <div class="input-group">
                                    <select name="mechanic_id" id="mechanic_id" class="form-control bg-dark text-light">
                                        @foreach ($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}">
                                                {{ $mechanic->name }}
                                                - <span class="rating">{{ number_format($mechanic->average_rating, 1) }} ⭐</span>

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
</x-layout>

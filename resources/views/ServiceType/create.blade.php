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
        }

        .input-group {
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-plus-circle"></i> Create New Service Type
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mechanic.service-type.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag"></i> Service Type Name:
                                </label>
                                <input type="text" name="name" id="name"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter Service Type Name" required>
                            </div>

                            <div class="form-group">
                                <label for="price" class="form-label">
                                    <i class="fas fa-dollar-sign"></i> Service Type Price (USD):
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-light">$</span>
                                    <input type="number" name="price" id="price"
                                        class="form-control bg-dark text-light placeholder-light"
                                        placeholder="Enter Service Type Price" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Create Service Type
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
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif
</x-layout>

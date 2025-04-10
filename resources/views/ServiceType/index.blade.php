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

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        /* Table styling */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #fff;
            background-color: #343a40;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #454d55;
        }

        .table thead th {
            vertical-align: middle;
            border-bottom: 2px solid #454d55;
            background-color: #23272b;
            font-weight: 600;
        }

        .table tbody+tbody {
            border-top: 2px solid #454d55;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 204, 0, 0.1);
        }

        /* Ensure even spacing */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        /* Status badges */
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
        }

        /* Card header colors */
        .bg-service {
            background-color: #6f42c1 !important;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-dark text-white">
                    <div class="card-header bg-service">
                        <h3 class="card-title text-center">
                            <i class="fas fa-tools"></i> Service Types Management
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('mechanic.service-type.create') }}" class="btn btn-warning">
                                <i class="fas fa-plus-circle"></i> Create New Service Type
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-tag"></i> Service Name</th>
                                        <th><i class="fas fa-dollar-sign"></i> Price</th>
                                        <th><i class="fas fa-calendar-alt"></i> Created At</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach ($serviceTypes as $serviceType)
                                        <tr id='row-{{ $serviceType->id }}'>
                                            <td>
                                                <strong>{{ $serviceType->name }}</strong>
                                            </td>
                                            <td>
                                                {{-- <span class="badge bg-success"> --}}
                                                {{ number_format($serviceType->price, 2) }}
                                                {{-- </span> --}}
                                            </td>
                                            <td>
                                                {{ $serviceType->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('mechanic.service-type.edit', $serviceType->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm btnDelete"
                                                    data-id="{{ $serviceType->id }}">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

    <script>
        $(document).ready(function() {
            // Add confirmation for delete actions
            $(document).on('click', '.btnDelete', function() {
                if (!confirm('Are you sure you want to delete this service type?')) {
                    return false;
                }
                let id = $(this).data('id');

                $.ajax({
                    url: '{{ route('mechanic.service-type.delete') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.msg);
                        $('#row-' + response.id).remove();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting the service type.');
                    }
                });
            });

            // Add hover effects
            $('.table-hover tbody tr').hover(
                function() {
                    $(this).css('cursor', 'pointer');
                },
                function() {
                    $(this).css('cursor', 'auto');
                }
            );
        });
    </script>
</x-layout>

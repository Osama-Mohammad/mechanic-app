<x-layout>
    <x-nav />
    <style>
        /* Custom CSS to make placeholder text visible */
        .form-control::placeholder {
            color: #ccc;
            opacity: 1;
        }
    </style>
    <div class="container mt-3"> <!-- Reduced margin-top -->
        <div class="row justify-content-center">
            <div class="col-md-5"> <!-- Reduced column width -->
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark py-2"> <!-- Reduced padding -->
                        <h3 class="card-title text-center mb-0"> <!-- Removed margin-bottom -->
                            <i class="fas fa-sign-in-alt"></i> Login
                        </h3>
                    </div>
                    <div class="card-body p-3"> <!-- Reduced padding -->
                        <form method="POST" action="/">
                            @csrf
                            <div class="mb-2"> <!-- Reduced margin-bottom -->
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email"
                                    class="form-control bg-dark text-light" placeholder="Enter Your Email">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div> <!-- Smaller font for error -->
                                @enderror
                            </div>
                            <div class="mb-2"> <!-- Reduced margin-bottom -->
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" placeholder="Enter Your Password"
                                    class="form-control bg-dark text-light">
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div> <!-- Smaller font for error -->
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-sm"> <!-- Smaller button -->
                                    <i class="fas fa-sign-in-alt"></i> Log In
                                </button>
                            </div>
                        </form>
                        @if (session('error'))
                            <div class="alert alert-danger mt-2 mb-0 p-2 small" role="alert"> <!-- Smaller alert -->
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-dark text-center py-2"> <!-- Reduced padding -->
                        <p class="mb-1 small">Don't have an account?</p> <!-- Smaller font -->
                        <a href="{{ route('mechanic.register.page') }}" class="btn btn-outline-primary btn-sm me-1">
                            <!-- Smaller button -->
                            <i class="fas fa-wrench"></i> Sign Up as Mechanic
                        </a>
                        <a href="{{ route('customer.register.page') }}" class="btn btn-outline-success btn-sm">
                            <!-- Smaller button -->
                            <i class="fas fa-user"></i> Sign Up as Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

        });
    </script>
</x-layout>

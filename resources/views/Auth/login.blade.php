<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic App - Login</title>
</head>

<body class="bg-dark text-light">
    <x-layout>
        <x-nav />

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" id="email" name="email"
                                        class="form-control bg-dark text-light">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control bg-dark text-light">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-sign-in-alt"></i> Log In
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer bg-dark text-center">
                            <p class="mb-2">Don't have an account?</p>
                            <a href="/mechanic/register/create" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-wrench"></i> Sign Up as Mechanic
                            </a>
                            <a href="/customer/register/create" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-user"></i> Sign Up as Customer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layout>
</body>

</html>

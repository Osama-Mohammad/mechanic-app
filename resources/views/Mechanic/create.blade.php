<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .placeholder-light::placeholder {
            color: #ccc;
            opacity: 1;
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-center">
                            <i class="fas fa-tools"></i> Sign Up As Mechanic
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/mechanic/register/store">
                            @csrf
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter your full name">
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" id="phone" name="phone"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="specialization" class="form-label">Specialization:</label>
                                <input type="text" id="specialization" name="specialization"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter your specialization">
                                @error('specialization')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="experience" class="form-label">Experience:</label>
                                <input type="text" id="experience" name="experience"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter your years of experience">
                                @error('experience')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter your email address">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="location" class="form-label">Location:</label>
                                <div class="input-group"> <!-- Input group to combine select and icon -->
                                    <select name="location" class="form-control bg-dark text-light">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text bg-dark border-dark">
                                        <i class="fas fa-caret-down text-light"></i>
                                    </span>
                                </div>
                                @error('location')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Enter a password">
                                <small class="form-text text-light">
                                    Password must be at least 8 characters long and contain at least one letter, one
                                    number, and one special character.
                                </small>
                                @error('password')
                                    <div class="alert alert-danger mt-2 mb-0 p-2 small" role="alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Confirm your password">
                                @error('password_confirmation')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid mb-3"> <!-- Standardized margin-bottom -->
                                <button id="btnAdd" type="submit" class="btn btn-warning">
                                    <i class="fas fa-user-plus"></i> Create Mechanic
                                </button>
                            </div>
                        </form>
                        <div class="card-footer bg-dark text-center py-2">
                            <p class="mb-1 small text-light">Have an Existing Account?</p>
                            <a href="/" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Login Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

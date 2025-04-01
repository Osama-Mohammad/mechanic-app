<x-layout>
    <x-nav />

    <style>
        /* Custom CSS to make placeholder text visible */
        .form-control::placeholder {
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
                            <i class="fas fa-tools"></i> Sign Up As Customer
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('customer.register.store') }}">
                            @csrf
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name"
                                    class="form-control bg-dark text-light" placeholder="Enter your full name">
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" id="phone" name="phone"
                                    class="form-control bg-dark text-light" placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="latitude" class="form-label">
                                    <i class="fas fa-map-marked-alt"></i> Latitude:
                                </label>
                                <input type="text" id="latitude" name="latitude"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Click 'Get My Location' to auto-fill" readonly>
                                @error('latitude')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="longitude" class="form-label">
                                    <i class="fas fa-map-marked-alt"></i> Longitude:
                                </label>
                                <input type="text" id="longitude" name="longitude"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Click 'Get My Location' to auto-fill" readonly>
                                @error('longitude')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Button centered below fields -->
                            <div class="mb-3 text-center">
                                <button type="button" class="btn btn-primary" onclick="getLocation()">
                                    <i class="fas fa-location-arrow"></i> Get My Location
                                </button>
                            </div>


                            
                            <div class="mb-3">
                                <label for="location" class="form-label">
                                    <i class="fas fa-city"></i> City:
                                </label>
                                <input type="text" id="location" name="location"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Click 'Get My Location' to auto-fill" readonly>
                                @error('location')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email"
                                    class="form-control bg-dark text-light" placeholder="Enter your email address">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password"
                                    class="form-control bg-dark text-light" placeholder="Create a password">
                                <small class="form-text text-light">
                                    Password must be at least 8 characters long and contain at least one letter, one
                                    number, and one special character.
                                </small>
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3"> <!-- Standardized margin-bottom -->
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control bg-dark text-light" placeholder="Confirm your password">
                                @error('password_confirmation')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid mb-3"> <!-- Standardized margin-bottom -->
                                <button id="btnAdd" type="submit" class="btn btn-warning">
                                    <i class="fas fa-user-plus"></i> Create Customer
                                </button>
                            </div>
                        </form>
                        <div class="card-footer bg-dark text-center py-2">
                            <p class="mb-1 small text-light">Have an Existing Account?</p>
                            <a href="{{ route('login.page') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Login Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        let latitude = position.coords.latitude;
                        let longitude = position.coords.longitude;

                        // Fill latitude & longitude fields
                        document.getElementById("latitude").value = latitude;
                        document.getElementById("longitude").value = longitude;

                        // Call function to get city name
                        getCityName(latitude, longitude);
                    },
                    function(error) {
                        alert("Unable to retrieve location. Please allow location access.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function getCityName(lat, lon) {
            let apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.address && data.address.city) {
                        document.getElementById("location").value = data.address.city;
                    } else if (data.address && data.address.town) {
                        document.getElementById("location").value = data.address.town;
                    } else if (data.address && data.address.village) {
                        document.getElementById("location").value = data.address.village;
                    } else {
                        document.getElementById("location").value = "City not found";
                    }
                })
                .catch(error => {
                    console.error("Error fetching city name:", error);
                    document.getElementById("location").value = "Error fetching city";
                });
        }
    </script>
</x-layout>

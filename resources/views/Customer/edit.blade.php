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
                            <i class="fas fa-user"></i> Edit Customer Profile
                        </h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('customer.profile.update', $customer->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control bg-dark text-light"
                                    value="{{ $customer->name }}" name="name">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" class="form-control bg-dark text-light"
                                    value="{{ $customer->phone }}" name="phone">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control bg-dark text-light"
                                    value="{{ $customer->email }}" name="email">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="latitude" class="form-label">
                                    <i class="fas fa-map-marked-alt"></i> Latitude:
                                </label>
                                <input type="text" id="latitude" name="latitude"
                                    class="form-control bg-dark text-light placeholder-light"
                                    placeholder="Click 'Get My Location' to auto-fill" value="{{ $customer->latitude }}"
                                    readonly>
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
                                    placeholder="Click 'Get My Location' to auto-fill"
                                    value="{{ $customer->longitude }}" readonly>
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
                                    placeholder="Click 'Get My Location' to auto-fill"
                                    value="{{ $customer->location }}" readonly>
                                @error('location')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="text" class="form-control bg-dark text-light" name="password"
                                    placeholder="Leave This Field Empty If You Don't Want To Change It"
                                    placeholder="Leave This Field Empty If You Don't Want To Change It">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input type="text" class="form-control bg-dark text-light"
                                    name="password_confirmation"
                                    placeholder="Leave This Field Empty If You Don't Want To Change It">
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </div>



                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>
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

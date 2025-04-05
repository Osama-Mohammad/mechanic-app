<body class="bg-dark text-light">
    <x-layout>
        <x-nav />
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-secondary text-white">
                        <div class="card-header bg-dark">
                            <h3 class="card-title text-center">
                                <i class="fas fa-user"></i> Edit Mechanic Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mechanic.profile.update', $mechanic) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->name }}" name="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->phone }}" name="phone">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->email }}" name="email">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>




                                <div class="mb-3">
                                    <label for="start_time" class="form-label">
                                        <i class="fas fa-clock"></i> Start Time:
                                    </label>
                                    <input type="time" id="start_time" name="start_time"
                                        class="form-control bg-dark text-light" value="{{ $mechanic->start_time }}"
                                        required>
                                    @error('start_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="end_time" class="form-label">
                                        <i class="fas fa-clock"></i> End Time:
                                    </label>
                                    <input type="time" id="end_time" name="end_time"
                                        class="form-control bg-dark text-light" value="{{ $mechanic->end_time }}"
                                        required>
                                    @error('end_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="workdays" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Workdays:
                                    </label>
                                    <select id="workdays" name="workdays[]" class="form-control bg-dark text-light"
                                        multiple required>
                                        @foreach ($days as $day)
                                            <option value="{{ $day }}"
                                                {{ in_array($day, $selected_days) ? 'selected' : '' }}>
                                                {{ $day }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-light">
                                        Hold Ctrl/Cmd to select multiple days
                                    </small>
                                    @error('workdays')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>







                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience:</label>
                                    <input type="text" class="form-control bg-dark text-light"
                                        value="{{ $mechanic->experience }}" name="experience">
                                    @error('experience')
                                        {{ $message }}
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="availability" class="form-label">Availability:</label>
                                    <div class="input-group">
                                        <select name="availability" id="availability"
                                            class="form-control bg-dark text-light">
                                            <option value="Available">Available</option>
                                            <option value="Busy">Busy</option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                        <span class="input-group-text bg-dark border-dark">
                                            <i class="fas fa-caret-down text-light"></i>
                                        </span>
                                    </div>
                                    @error('availability')
                                        {{ $message }}
                                    @enderror
                                </div>





                                <div class="mb-3">
                                    <label for="latitude" class="form-label">
                                        <i class="fas fa-map-marked-alt"></i> Latitude:
                                    </label>
                                    <input type="text" id="latitude" name="latitude"
                                        class="form-control bg-dark text-light placeholder-light"
                                        placeholder="Click 'Get My Location' to auto-fill"
                                        value="{{ $mechanic->latitude }}" readonly>
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
                                        value="{{ $mechanic->longitude }}" readonly>
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
                                        value="{{ $mechanic->location }}" readonly>
                                    @error('location')
                                        <div class="text-danger small">{{ $message }}</div>
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

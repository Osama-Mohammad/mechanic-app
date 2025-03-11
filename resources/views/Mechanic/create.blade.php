<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic App</title>
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
                                <i class="fas fa-tools"></i> Sign Up As Mechanic
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/mechanic/register/store">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control bg-dark text-light">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" id="phone" name="phone"
                                        class="form-control bg-dark text-light">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">specialization:</label>
                                    <input type="text" id="specialization" name="specialization"
                                        class="form-control bg-dark text-light">
                                    @error('specialization')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="experience" class="form-label">experience:</label>
                                    <input type="text" id="experience" name="experience"
                                        class="form-control bg-dark text-light">
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
                                    <label for="rating" class="form-label">rating:</label>
                                    <input type="text" id="rating" name="rating"
                                        class="form-control bg-dark text-light">
                                    @error('rating')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" id="email" name="email"
                                        class="form-control bg-dark text-light">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="text" id="password" name="password"
                                        class="form-control bg-dark text-light">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                    <input type="text" id="password_confirmation" name="password_confirmation"
                                        class="form-control bg-dark text-light">
                                    @error('password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>

                        <div class="d-grid">
                            <button id="btnAdd" type="submit" class="btn btn-warning">
                                <i class="fas fa-user-plus"></i> Create Mechanic
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <script>
            $(document).ready(function() {
                // $(document).on('click', '#btnAdd', function() {
                //     const name = $('#name').val();
                //     const email = $('#email').val();
                //     const password = $('#password').val();

                //     $('#errorname').text('');
                //     $('#erroremail').text('');
                //     $('#errorpassword').text('');

                //     $.ajax({
                //         url: '/customer/store',
                //         type: 'POST',
                //         data: {
                //             'name': name,
                //             'email': email,
                //             'password': password,
                //             '_token': '{{ csrf_token() }}'
                //         },
                //         success: function(data) {
                //             alert(data.msg);
                //             alert('Customer Name: ' + data.customer.name);
                //         },
                //         error: function(xhr, status, error) {
                //             if (xhr.status === 422) {
                //                 // Validation errors
                //                 const errors = xhr.responseJSON.errors;
                //                 for (const field in errors) {
                //                     // Display the first error message for each field
                //                     $(`#error${field}`).text(errors[field][0]);
                //                 }
                //             } else {
                //                 // Other errors
                //                 alert('An error occurred. Please try again.');
                //                 console.error(xhr.responseText);
                //             }
                //         }
                //     });
                // });
            });
        </script>
    </x-layout>
</body>

</html>

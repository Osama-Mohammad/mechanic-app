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
                                <i class="fas fa-tools"></i> Sign Up As Customer
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/customer/register/store">
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
                                    <label for="location" class="form-label">Location:</label>
                                    <input type="text" id="location" name="location"
                                        class="form-control bg-dark text-light">
                                    @error('location')
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
                                <div class="d-grid">
                                    <button id="btnAdd" type="submit" class="btn btn-warning">
                                        <i class="fas fa-user-plus"></i> Create Customer
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
                //     const phone = $('#phone').val();
                //     const location = $('#location').val();

                //     $('#errorname').text('');
                //     $('#errorphone').text('');
                //     $('#errorlocation').text('');

                //     $.ajax({
                //         url: '/customer/store',
                //         type: 'POST',
                //         data: {
                //             'name': name,
                //             'phone': phone,
                //             'location': location,
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

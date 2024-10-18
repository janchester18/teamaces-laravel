<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TeamAces Driving Academy</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body, html {
            height: 100%; /* Full height */
            margin: 0; /* Remove default margin */
            display: flex; /* Flexbox for centering */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            background-color: #FCF8F3; /* Background color */
        }
        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="images/awards-image.png"
                         class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
                        @csrf <!-- Include CSRF token -->
                        <h1 class="text-center m-5"><strong>Admin Login</strong></h1>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form1Example13" class="form-control form-control-lg" name="email" placeholder="Enter email" required />
                            <label class="form-label" for="form1Example13">Email address</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="form1Example23" class="form-control form-control-lg" name="password" placeholder="Password" required />
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <label class="form-label mb-0" for="form1Example23">Password</label>
                                <a href="#!" class="text-muted">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Create FormData object

            // Make AJAX request
            fetch(this.action, { // Use the form's action URL
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Set this header to identify the request as AJAX
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                }
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        // If the response is not okay, reject it to go to the catch block
                        return Promise.reject(data);
                    }
                    return data; // Return the data if the response is okay
                });
            })
            .then(data => {
                // If the data has a redirect, handle it
                if (data.redirect) {
                    window.location.href = data.redirect; // Redirect on success
                }
            })
            .catch(error => {
                // Handle errors from the response or network errors
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'There was an issue processing your request.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>

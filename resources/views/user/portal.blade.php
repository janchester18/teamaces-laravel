<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Driving Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aces.png') }}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            align-items: stretch;
        }
        .split-screen {
            display: flex;
            width: 100%;
        }
        .login-container {
            margin-top: 120px;
            flex: 0 0 30%; /* Left side is 30% */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #ffffff;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
        }
        .hero-container {
            flex: 0 0 70%; /* Right side is 70% */
            background-image: url('images/user-background.png?height=1080&width=1920');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 2rem;
        }
        .hero-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
            }
            .hero-container {
                min-height: 300px;
            }
        }
        #gallery-container {
            margin-top: 120px;
        }
        .modal-dialog {
            max-width: 100%;
            margin: 0 auto;
        }
        .modal-header {
            display: flex;
            justify-content: flex-end;
        }
        .btn-close {
            border: 0;
            background-color: transparent;
        }
        .navbar-nav #portal {
            color: #a1a1a1;
        }
        .navbar-nav #highlights {
            color: white !important;
        }
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0 auto;
                top: 25%;
                transform: translateY(-25%);
            }
        }
    </style>
</head>
<body>

    @include('user.loading') <!-- Include the loading screen -->
    <!-- Navigation -->
    @extends('layout.app')
    <div class="split-screen">
        <div class="login-container">
            <div class="login-form">
                <h2 class="text-center mb-4">Login</h2>
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Forgot password?</a>
                </div>
            </div>
        </div>
        <div class="hero-container">
            <div class="hero-content">
                <h1>Welcome to TeamAces Driving Academy Portal</h1>
                <p>Students can view the courses they are enrolled in and their schedules.</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            document.getElementById('loading-screen').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        };

        document.addEventListener('DOMContentLoaded', function () {
            let currentIndex = 0;
            const images = document.querySelectorAll('.gallery-img');
            const modalImage = document.getElementById('modal-image');
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

            // Open modal and display clicked image
            images.forEach((img, index) => {
                img.addEventListener('click', () => {
                    currentIndex = index;
                    showImage();
                    imageModal.show();
                });
            });

            // Show the image in the modal
            function showImage() {
                const img = images[currentIndex];
                modalImage.src = img.src;
                modalImage.alt = img.alt;
            }

            // Next image
            document.getElementById('nextBtn').addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % images.length;
                showImage();
            });

            // Previous image
            document.getElementById('prevBtn').addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>

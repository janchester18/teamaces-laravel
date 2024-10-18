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

        /* Button styling */
    #backToTopBtn {
        opacity: 0; /* Start invisible */
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        width: 50px;
        height: 50px;
        border: none;
        outline: none;
        background-color: #007bff;
        border-radius: 50%;
        cursor: pointer;
        padding: 10px;
        opacity: 0; /* Start with the button being fully transparent */
        transition: opacity 0.3s ease-in-out; /* Smooth transition for opacity */
    }

    #backToTopBtn img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: brightness(0) invert(1); /* Make image white */
    }

    #backToTopBtn:hover {
        background-color: #0056b3; /* Darker color on hover */
    }

    /* Entry animation (fade in) */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); } /* Starts hidden and moves up */
        to { opacity: 1; transform: translateY(0); } /* Ends visible */
    }

    /* Exit animation (fade out) */
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(30px); } /* Moves down when hidden */
    }

    /* When the button is visible */
    #backToTopBtn.show {
        display: block;
        animation: fadeIn 0.5s ease-in-out forwards; /* Trigger the fade-in animation */
        opacity: 1;
        visibility: visible;
    }

    /* When the button is hidden */
    #backToTopBtn.hide {
        opacity: 0;
        animation: fadeOut 0.2s ease-in-out forwards; /* Trigger the fade-out animation */
    }
    .navbar-hidden {
            position: fixed;
            top: -110px !important;
            /* Adjust this value based on your navbar height */
            transition: top 0.3s;
            /* Smooth transition for the hide/show effect */
        }
    </style>
</head>
<body>
            <!-- Back to Top Button -->
            <button onclick="scrollToTop()" id="backToTopBtn" title="Go to top">
                <img src="{{ asset('images/arrow-up.svg') }}" alt="Back to Top">
            </button>

    @include('user.loading') <!-- Include the loading screen -->
    <!-- Navigation -->
    @extends('layout.app')
    <div class="split-screen">
        <div class="login-container">
            <div class="login-form">
                <h2 class="text-center mb-4">Login</h2>
                <form method="POST" action="{{ route('student.login.submit') }}">
                    @csrf <!-- Add this for Laravel's CSRF protection -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.querySelector('.navbar');
            var lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                var currentScrollTop = window.scrollY;

                if (currentScrollTop > lastScrollTop) {
                    // Scrolling down
                    navbar.classList.add('navbar-hidden');
                } else {
                    // Scrolling up
                    navbar.classList.remove('navbar-hidden');
                }

                lastScrollTop = currentScrollTop;
            });
        });


                window.onscroll = function() { scrollFunction() };

        function scrollFunction() {
            const btn = document.getElementById("backToTopBtn");
            // Show the button when scrolled more than 100px from the top
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                btn.classList.add('show');
                btn.classList.remove('hide');
            } else {
                btn.classList.add('hide');
                btn.classList.remove('show');
            }
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>

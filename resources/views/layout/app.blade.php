<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gallery')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Bootstrap CSS -->
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Bootstrap JS -->

    <style>
        <style>
        body {
            font-family: 'Open Sans', sans-serif;
            padding-top: 80px; /* Adjusted to prevent content from hiding behind navbar */
        }

        .navbar {
            background-color: rgba(50, 50, 50, 0.75) !important;
            border-bottom: .1px solid rgb(90, 90, 90);
            padding-left: 20px;
            padding-right: 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: top 0.3s ease;
            /* Smooth transition for the hide/show effect */
        }

        .navbar-brand img {
            height: 50px;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: none;
            width: 30px;
            height: 30px;
            position: relative;
        }

        .navbar-toggler-icon::before {
            content: "\2630";
            font-size: 24px;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .navbar-nav {
            text-align: center;
        }

        .navbar-nav .nav-item {
            margin: 0 15px;
            /* Increase space between nav items */
        }

        .navbar-nav .nav-link {
            display: block;
            padding: 10px;
            color: white;
            font-weight: bold;
            /* Make text bold */
            transition: all 0.3s ease;
            /* Smooth transition for hover effects */
        }

        .navbar-nav #highlights {
            color: #a1a1a1;
        }

        .navbar-nav .nav-link:hover {
            color: #a1a1a1 !important;
            /* Lighter color on hover */
            text-shadow: 1px 1px 4px rgba(71, 71, 71, 0.5);
            /* Add text shadow on hover */
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-content {
            margin-bottom: 40px;
        }

        .section-content .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Footer Section */
        .footer-content {
            background: #000D1FFF;
            color: #fff;
            padding: 40px 0;
        }

        .footer-content h4 {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .footer-content p {
            margin: 5px 0;
            font-size: 16px;
        }

        .contact-item {
            display: inline-block;
            margin: 0 10px;
        }

        .footer-content .social-media {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-content .social-media li {
            display: inline;
            margin-right: 10px;
        }

        .footer-content .social-icon {
            color: #fff;
            font-size: 20px;
            transition: color 0.3s;
        }

        .footer-content .social-icon:hover {
            color: #FFC107;
        }

        .footer-bottom {
            margin-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive font sizes */
        @media (max-width: 1199.98px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero h2 {
                font-size: 1.25rem;
            }

            .hero .btn {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 991.98px) {
            .hero h1 {
                font-size: 3rem;
            }

            .hero h2 {
                font-size: 1.1rem;
            }

            .hero .btn {
                font-size: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero h2 {
                font-size: 1rem;
            }

            .hero .btn {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 575.98px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero h2 {
                font-size: 0.9rem;
            }

            .hero .btn {
                font-size: 0.8rem;
            }
        }

        /* Animation keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    opacity: 0;
    animation: fadeIn 1s ease-out forwards;
}

/* Optional: stagger animations */
.fade-in-delay {
    animation-delay: 0.5s;
}

.fade-in-delay-2 {
    animation-delay: 1s;
}

.fade-in-delay-3 {
    animation-delay: 1.5s;
}

.fade-in-delay-4 {
    animation-delay: 2s;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/aces.png" alt="TeamAces Logo" style="width: 80px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="about" class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('branches') }}">Branches</a>
                    </li>
                    <li class="nav-item">
                        <a id="contact" class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a id="highlights" class="nav-link" href="{{ route('user.gallery') }}">Highlights</a>
                    </li>
                    <li class="nav-item">
                        <a id="portal" class="nav-link" href="{{ route('user.portal') }}">Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Add Bootstrap JS, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @yield('scripts') <!-- Section for additional scripts if needed -->
</body>
</html>

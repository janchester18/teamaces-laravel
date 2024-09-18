<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Driving Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
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

        .navbar-nav #branches {
            color: #a1a1a1;
        }

        .navbar-nav .nav-link:hover {
            color: #a1a1a1 !important;
            /* Lighter color on hover */
            text-shadow: 1px 1px 4px rgba(71, 71, 71, 0.5);
            /* Add text shadow on hover */
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

.footer-content .footer-bottom {
    margin-top: 5px;
}

.footer-content .footer-bottom p {
    margin: 0;
    font-size: 14px;
}

#branch-container {
    margin-top: 120px;
    margin-bottom: 50px;
}

#map {
    height: 500px;
    width: 100%;
}

.branch-list-item {
    cursor: pointer;
    padding: 10px;
    transition: background-color 0.3s;
}

.branch-list-item:hover {
    background-color: #f0f0f0;
}

.branch-list-item.active {
    background-color: #7CB1DCFF; /* Active item styling */
    color: white;
}

/* Set the height of the branch list to match the map and enable scrolling */
ul.list-group {
    max-height: 500px;
    overflow-y: auto;
    padding-right: 15px; /* To prevent cutting off the scrollbar */
}




        /* Responsive font sizes */
        @media (max-width: 1199.98px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero h2 {
                font-size: 2.25rem;
            }

            .hero .btn {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 991.98px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero h2 {
                font-size: 2.25rem;
            }

            .hero .btn {
                font-size: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .hero h1 {
                font-size: 1.5rem;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .hero .btn {
                font-size: 0.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .hero h1 {
                font-size: 1rem;
                padding-left: 30px;
                padding-right: 30px;
            }

            .hero h2 {
                font-size: 1.3rem;
            }

            .hero .btn {
                font-size: 0.8rem;
            }

            .courses-title {
                font-size: 2rem !important;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
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
                        <a id="home" class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a id="courses" class="nav-link" href="{{ route('courses') }}">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a id="branches" class="nav-link" href="{{ route('branches') }}">Branches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.gallery') }}">Highlights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.portal') }}">Portal</a>
                    </li>
                </ul>


            </div>
        </div>
    </nav>

    <div id="branch-container" class="container-fluid">
        <div class="row">
            <!-- Branches List on the Left -->
            <h1 class="mb-5 text-center"><strong>Branches All Around the Country</strong></h1>
            <div class="col-md-4 mb-3">
                <h5 class="text-center"><strong>Our Locations</strong></h5>
                <ul class="list-group">
                    @foreach($branches as $branch)
                        <li class="list-group-item branch-list-item" data-lat="{{ $branch->latitude }}" data-lng="{{ $branch->longitude }}">
                            <strong>{{ $branch->name }}</strong><br>
                            {{ $branch->address }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Dynamic Map on the Right -->
            <div class="col-md-8">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Leaflet.js JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Initialize the map and set the default view
        var map = L.map('map').setView([37.7749, -122.4194], 4); // Default view of the map

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Branch list items click event
        document.querySelectorAll('.branch-list-item').forEach(function(item) {
            item.addEventListener('click', function() {
                // Remove 'active' class from all list items
                document.querySelectorAll('.branch-list-item').forEach(function(i) {
                    i.classList.remove('active');
                });

                // Add 'active' class to clicked item
                this.classList.add('active');

                // Get latitude and longitude from the clicked item
                var lat = parseFloat(this.getAttribute('data-lat'));
                var lng = parseFloat(this.getAttribute('data-lng'));

                // Set the map view to the selected branch location and zoom in
                map.setView([lat, lng], 14);

                // Optionally, add a marker to the map for the selected branch
                L.marker([lat, lng]).addTo(map).bindPopup(this.innerText).openPopup();
            });
        });
    </script>


    <footer id="footer" class="footer-content section-padding">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-12 text-center mb-4">
                    <h4>Contact Us</h4>
                    <p>
                        <span class="contact-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                          </svg> #1 National Highway, Bolbok, Batangas City</span> |
                        <span class="contact-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                          </svg> (043)7845186</span> |
                        <span class="contact-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone-fill" viewBox="0 0 16 16">
                            <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0"/>
                          </svg> 09193856006</span> |
                        <span class="contact-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                          </svg> info@teamacesdriving.com</span>
                    </p>
                </div>

                <!-- Social Media Links -->
                <div class="col-md-12 text-center mb-4">
                    <h4>Follow Us</h4>
                    <ul class="social-media">
                        <li><a href="https://web.facebook.com/TeamAcesDrivingHeadOffice" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                          </svg></a></li>
                        <li><a href="https://www.instagram.com/teamacesdrivingacademy/" class="social-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                          </svg></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p>&copy; 2024 TeamAces Driving Academy. All Rights Reserved.</p>
            </div>
        </div>
    </footer>







    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Add this script before the closing </body> tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.querySelector('.navbar');
            var heroHeight = document.querySelector('.hero').offsetHeight;

            window.addEventListener('scroll', function() {
                if (window.scrollY > heroHeight) {
                    navbar.classList.add('navbar-hidden');
                } else {
                    navbar.classList.remove('navbar-hidden');
                }
            });
        });
    </script>

</body>

</html>

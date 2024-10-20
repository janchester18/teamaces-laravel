<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Driving Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('images/aces.png') }}">
</head>
<style>
    html {
        scroll-behavior: smooth;
        }
   body {
            font-family: 'Open Sans', sans-serif;
            padding-top: 0px;
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
        }

        .navbar-nav .nav-link {
            display: block;
            padding: 10px;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .navbar-nav #contact {
            color: #a1a1a1;
        }

        .navbar-nav .nav-link:hover {
            color: #a1a1a1 !important;
            text-shadow: 1px 1px 4px rgba(71, 71, 71, 0.5);
        }

        .hero {
            background-color: #007bff;
            color: white;
            padding-top: 200px;
            padding-bottom: 100px;
            margin-top: 0px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.25rem;
        }

        .btn-custom {
            font-weight: bold;
            padding: 10px 20px;
            margin: 10px;
        }

        .btn-franchise {
            background-color: #ffc107;
            color: #007bff;
        }

        .contact-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

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

        .fade-in-delay-1 {
            animation-delay: 0.2s;
        }

        .fade-in-delay-2 {
            animation-delay: 0.4s;
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

        #contact-container {
            margin-bottom: 30px;
            margin-top: 30px;
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
            top: -110px;
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
                        <a class="nav-link" href="{{ route('user.gallery') }}">Highlights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.portal') }}">Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
<section class="hero">
    <div class="container text-center">
        <h1 class="mb-4 fade-in">Contact TeamAces Driving Academy</h1>
        <p class="mb-5 fade-in fade-in-delay-1">Get in touch with us for any inquiries or to start your journey towards becoming a confident driver.</p>
        <div class="fade-in fade-in-delay-2">
            <a href="#" class="btn btn-custom btn-franchise" data-bs-toggle="modal" data-bs-target="#contactModal">Get in Touch</a>
        </div>
    </div>
</section>

<!-- Contact Form Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Get in Touch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="franchise-info m-5 py-4 bg-white">
    <h2 class="text-center font-weight-bold mb-4">Secure a Driving School Franchise in Your Area</h2>
    <p class="text-center">
        TeamAces Driving Academy Inc. is excited to offer franchise opportunities. We currently have over 10 franchise branches nationwide, with our latest addition in Naic, Cavite, and more branches opening soon!
    </p>

    <div class="text-center mb-4">
        <img src="images/franchise_header.jpg" alt="Franchise Header" class="img-fluid">
    </div>

    <h3 class="font-weight-bold text-primary text-center mb-3">Our Branch Locations</h3>
    <ul class="list-unstyled text-center mb-4">
        <li>Bauan, Lemery, Tanauan, Lipa, Rosario, Batangas City</li>
        <li>Calamba, Paranaque City, Danao, Mandaue Cebu City</li>
        <li>Pila Laguna, Famy Laguna, Naic Cavite</li>
        <li>San Jose Del Monte Bulacan, Rosales Pangasinan</li>
    </ul>

    <div class="alert alert-info text-center">
        <strong>Note:</strong> We only accept 1 franchise branch in one city/town or within a 10Km radius on a first-come, first-served basis. Franchise locations are subject to approval.
        Inquire and reserve your prospected franchise location to secure the zoning area!
    </div>

    <h3 class="font-weight-bold text-primary text-center mb-3">Franchise Package Inclusions</h3>

    <!-- Franchise Package Inclusions -->
    <div class="franchise-package">
        <div class="row text-center">
            <div class="col-md-4 col-12 mb-4">
                <img src="images/accreditation-lto-team-aces.png" alt="LTO Accreditation Assistance" class="img-fluid">
                <h5 class="font-weight-bold">LTO Accreditation Assistance</h5>
                <p>We will process the LTO accreditation at your location's Regional Office. You only need to handle other legal documents.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/instructor-training-team-aces-removebg-preview.png" alt="Intensive Instructor Training" class="img-fluid">
                <h5 class="font-weight-bold">Intensive Instructor Training</h5>
                <p>Your driving instructors will receive comprehensive training at our head office to ensure consistent service across all branches.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/admin-staff-training-team-aces_orig.png" alt="Admin Staff Training" class="img-fluid">
                <h5 class="font-weight-bold">Admin Staff Training</h5>
                <p>We conduct training for your admin staff to instill a "Service Over Profit" mentality, ensuring quality service.</p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 col-12 mb-4">
                <img src="images/it-system-team-aces-stradcom.png" alt="ACES IT System Training" class="img-fluid">
                <h5 class="font-weight-bold">ACES IT System Training</h5>
                <p>Our staff will train on the automated processing of LTO licenses using the ACES IT System based on new regulations.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/screen-shot-2020-03-02-at-17-removebg-preview_orig.png" alt="Manual Vehicle Downpayment" class="img-fluid">
                <h5 class="font-weight-bold">Manual Vehicle Downpayment</h5>
                <p>Your franchise package includes a downpayment for a fully equipped manually operated vehicle with safety features.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/screen-shot-2020-03-02-at-17-removebg-preview-1_orig.png" alt="Automatic Vehicle Downpayment" class="img-fluid">
                <h5 class="font-weight-bold">Automatic Vehicle Downpayment</h5>
                <p>Your package also includes a downpayment for a fully equipped automatic vehicle, ensuring safety for both student and instructor.</p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 col-12 mb-4">
                <img src="images/icon-prep-cahier_orig.png" alt="Business Operations Documents" class="img-fluid">
                <h5 class="font-weight-bold">Business Operations Documents</h5>
                <p>We provide all necessary documents for smooth daily operations, from student enrollment to obtaining driver's licenses.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/fig-dm01_orig.png" alt="Online Presence & Marketing Support" class="img-fluid">
                <h5 class="font-weight-bold">Online Presence & Marketing Support</h5>
                <p>Your franchise will have an online presence on our website, helping you attract clients through effective marketing.</p>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <img src="images/team-aces-pos-system.jpeg" alt="Messenger App & POS System" class="img-fluid">
                <h5 class="font-weight-bold">Messenger App & POS System Included</h5>
                <p>Our app allows 24/7 online enrollment, and our POS system helps track sales and employee hours efficiently.</p>
            </div>
        </div>
    </div>

    <h3 class="font-weight-bold text-primary text-center mb-3">Franchise Package for Only Php 1,200,000.00</h3>
    <p class="text-center">
        <strong>Package Breakdown:</strong>
        <ul class="list-unstyled text-center package-breakdown">
            <li>Php 850,000.00 for the TeamAces Driving Academy system</li>
            <li>Php 120,000.00 for the downpayment of a manual vehicle</li>
            <li>Php 120,000.00 for the downpayment of an automatic vehicle</li>
            <li>Php 110,000.00 as the franchise bond (3-year contract)</li>
        </ul>
        <p class="text-center text-primary font-italic bg-light border border-primary p-2 my-3">
            Monthly amortization will be shouldered by the franchisee.
        </p>
    </p>


    <div class="alert alert-info text-center mb-4">
        <strong>Franchise Obligations:</strong> A monthly 8% royalty fee is based on sales recorded in the ACES IT system.
    </div>

    <h3 class="font-weight-bold text-primary text-center mb-3">Franchise Bonuses</h3>
    <ul class="list-unstyled text-center">
        <li>Location Assistance</li>
        <li>Pre-Opening Assistance</li>
        <li>Franchise Seminar</li>
    </ul>

    <h3 class="font-weight-bold text-center mb-4">Join Us Today!</h3>
    <p class="text-center">
        Be one of our top franchisees! We're here to help you grow your franchise business with us.
    </p>
</div>

<style>


    .franchise-package .img-fluid {
        max-height: 200px; /* Limit image height for uniformity */
    }

    @media (max-width: 767.98px) {
        .franchise-package .img-fluid {
            max-width: 100%; /* Ensure images fit within mobile screens */
            height: auto;
        }
    }

    .step-image {
        max-width: 100%;
        height: auto;
    }
</style>

<!-- Add a horizontal line -->
<hr class="my-4"> <!-- You can adjust the margin as needed -->

<!-- Franchise Steps -->
<div class="franchise-steps m-5 py-4 bg-white">
    <h2 class="text-center font-weight-bold mb-5">How to Franchise with Us</h2>

    <!-- Step 1 -->
    <div class="step mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 col-12 text-center mb-3 mb-md-0">
                <img src="images/team-aces-form_orig.jpg" alt="Step 1" class="img-fluid" style="max-width: 100%; max-height: 200px; height: auto;">
            </div>
            <div class="col-md-6 col-12">
                <h3 class="font-weight-bold text-primary">Step 1: Franchise Application</h3>
                <p>
                    Download and fill out the Franchise Application Form:
                    <a href="images/teamaces_application_form.pdf" download target="_blank" class="btn btn-outline-primary btn-sm">Download Form</a>.
                    After filling it out, send it via email to our Franchise Manager at
                    <a href="mailto:bodegasjohnny@gmail.com">bodegasjohnny@gmail.com</a> for approval.
                </p>
                <div class="alert alert-info mt-3">
                    <strong>After Sending:</strong> Send us a text message with your details:
                    <ul class="mt-2 list-unstyled">
                        <li><strong>Name:</strong> Your Full Name</li>
                        <li><strong>Address:</strong> Your Complete Address</li>
                        <li><strong>Email Address:</strong> Your Email</li>
                        <li><strong>Available Time for Phone Call:</strong> Your Available Hours</li>
                        <li><strong>Send To:</strong> SMART - 0908-187-5826 | GLOBE - 0945-7147-536</li>
                    </ul>
                </div>
                <p>
                    We will arrange a phone or Zoom meeting to discuss the details and answer your questions.
                </p>
            </div>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="step mb-5">
        <div class="row align-items-center flex-md-row-reverse">
            <div class="col-md-6 col-12 text-center mb-3 mb-md-0">
                <img src="images/contact-mail.png" alt="Step 2" class="img-fluid" style="max-width: 100%; max-height: 200px; height: auto;">
            </div>
            <div class="col-md-6 col-12">
                <h3 class="font-weight-bold text-primary">Step 2: Phone Interview & Decision</h3>
                <p>
                    After the phone interview with our Marketing Representative, if you decide to proceed with franchising, we will schedule a personal meeting.
                    Be sure to prepare the following documents:
                </p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success"></i> 1 valid ID</li>
                    <li><i class="fas fa-check-circle text-success"></i> 2 pieces 2x2 photos</li>
                    <li><i class="fas fa-check-circle text-success"></i> Filled-out application form</li>
                    <li><i class="fas fa-check-circle text-success"></i> Signed franchise contract</li>
                    <li><i class="fas fa-check-circle text-success"></i> Php 600,000.00 or 50% franchise fee (dated check)</li>
                    <li><i class="fas fa-check-circle text-success"></i> Post-dated check for the remaining balance</li>
                </ul>
                <p class="mt-3">
                    These documents will be required during the orientation and personal meeting.
                </p>
            </div>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="step mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 col-12 text-center mb-3 mb-md-0">
                <img src="images/screen-shot-2020-03-02-at-22-39-40.png" alt="Step 3" class="img-fluid" style="max-width: 100%; max-height: 200px; height: auto;">
            </div>
            <div class="col-md-6 col-12">
                <h3 class="font-weight-bold text-primary">Step 3: Location Assistance</h3>
                <p>
                    We will help with location approval for clients who already have a site. If you don’t have a location, we will provide assistance in finding one.
                </p>
                <p><strong>Tip:</strong> Choose a spot with foot traffic, near city centers or LTO offices to increase franchise sales.</p>
                <div class="alert alert-warning">
                    <strong>Note:</strong> Location assistance is provided only after signing the contract and settling 50% of the Php 600,000.00 franchise fee.
                </div>
            </div>
        </div>
    </div>

    <!-- Step 4 -->
    <div class="step mb-5">
        <div class="row align-items-center flex-md-row-reverse">
            <div class="col-md-6 col-12 text-center mb-3 mb-md-0">
                <img src="images/processing-reno.png" alt="Step 4" class="img-fluid" style="max-width: 100%; max-height: 200px; height: auto;">
            </div>
            <div class="col-md-6 col-12">
                <h3 class="font-weight-bold text-primary">Step 4: Processing & Renovation</h3>
                <p>
                    The office renovation process typically lasts 1-2 months, depending on the location. While waiting, we will arrange franchise seminars, and staff training sessions for driving instructors.
                </p>
                <p>
                    During this period, you can also begin applying for business permits and other legal documents required by your local government.
                </p>
            </div>
        </div>
    </div>

    <!-- Step 5 -->
    <div class="step mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 col-12 text-center mb-3 mb-md-0">
                <img src="images/openning.png" alt="Step 5" class="img-fluid" style="max-width: 100%; max-height: 200px; height: auto;">
            </div>
            <div class="col-md-6 col-12">
                <h3 class="font-weight-bold text-primary">Step 5: Branch Opening & Pre-Opening Assistance</h3>
                <p>
                    The branch will be handed over to you after the completion of renovations. We will also provide pre-opening assistance to ensure smooth operations on your first day.
                </p>
                <p>
                    Get ready to begin your exciting journey with us!
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .step-image {
            max-width: 80%;
            height: auto;
        }
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }
</style>


        <!-- Franchise CTA -->
        <div class="text-center">
            <a href="images/teamaces_application_form.pdf" download target="_blank" class="btn btn-custom btn-franchise">Download Franchise Application Form</a>
            <p class="mt-3">Have questions? Contact us at <a href="tel:+639081875826">0908-187-5826</a> or <a href="mailto:bodegasjohnny@gmail.com">bodegasjohnny@gmail.com</a></p>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting the default way

                // Grab the form data
                let name = $('#name').val();
                let email = $('#email').val();
                let message = $('#message').val();

                $.ajax({
                    url: "{{ route('inquiries.store') }}", // Route to handle form submission
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        name: name,
                        email: email,
                        message: message,
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                        // Reset form fields
                        $('#contactForm')[0].reset();
                    },
                    error: function(xhr) {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

</body>


<!-- Footer -->
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>





    <script>
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

    document.querySelector('.btn-franchise').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent default anchor behavior
  document.querySelector('#franchise-section').scrollIntoView({
    behavior: 'smooth'
  });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

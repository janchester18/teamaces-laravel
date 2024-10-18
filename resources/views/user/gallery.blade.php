<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Driving Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/aces.png') }}">
</head>
<style>
    #gallery-container {
        margin-top: 120px;
    }
    <style>
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
</style>

<body>
        <!-- Back to Top Button -->
        <button onclick="scrollToTop()" id="backToTopBtn" title="Go to top">
            <img src="{{ asset('images/arrow-up.svg') }}" alt="Back to Top">
        </button>

    <!-- Navigation -->

    @include('user.loading')
    @extends('layout.app')


<div id="gallery-container" class="container">
    <h1 class="text-center mb-5"><strong>Our Clients</strong></h1>

    <!-- Gallery Grid -->
    <div class="row">
        <!-- Hardcoded Images -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/1.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="0" alt="Client 1">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/2.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="1" alt="Client 2">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/3.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="2" alt="Client 3">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/4.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="3" alt="Client 4">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/5.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="0" alt="Client 1">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/6.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="1" alt="Client 2">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/7.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="2" alt="Client 3">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/8.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="3" alt="Client 4">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/9.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="0" alt="Client 1">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/10.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="1" alt="Client 2">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/11.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="2" alt="Client 3">
        </div>
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <img src="{{ asset('images/clients/12.jpg') }}" class="img-fluid img-thumbnail gallery-img" data-index="3" alt="Client 4">
        </div>
    </div>

    <!-- Modal for Image Viewing -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: 0px; background-color:transparent;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="modal-image" class="img-fluid" alt="Client Image">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" id="prevBtn">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>


@extends('layout.footer')





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

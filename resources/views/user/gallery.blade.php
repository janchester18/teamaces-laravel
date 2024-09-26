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
</style>
</style>

<body>

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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

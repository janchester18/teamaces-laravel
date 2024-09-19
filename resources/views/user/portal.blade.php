<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Driving Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

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
    .navbar-nav #portal {
            color: #a1a1a1;
    }
    .navbar-nav #highlights{
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
</style>

<body>

    <!-- Navigation -->


    @extends('layout.app')


    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow" style="width: 400px;">
            <h3 class="text-center mb-4">Portal Login</h3>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>


@extends('layout.footer')





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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>

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
    #contact-container{
        margin-top: 120px;
        height: 80vh;
    }

    #submit-button{
        width: 100px;
    }
    .navbar-nav #contact {
            color: #a1a1a1;
    }
    .navbar-nav #highlights{
        color: white !important;
    }
</style>
</style>

<body>

    <!-- Navigation -->


    @extends('layout.app')


    <div id="contact-container" class="container">
        <h2 class="text-center mb-4">Do you have a concern? Give us a message!</h2>
        <div class="row g-3">
          <!-- Left side (Name, Email, Phone) -->
          <div class="col-md-6">
            <div class="form-group mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <div class="form-group mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
            </div>
          </div>

          <!-- Right side (Message) -->
          <div class="col-md-6">
            <div class="form-group mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="6" placeholder="Enter your message"></textarea>
            </div>
          </div>
        </div>

        <div class="text-center mt-4">
          <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Enroll New Course</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
  <style>
    body {
        font-family: 'Open Sans', sans-serif;
    }

    /* Custom navbar color */
    .navbar-custom {
      background-color: #141820;
    }

    /* Add padding to main content */
    .content-wrapper {
      padding-left: 15px;
      padding-right: 15px;
    }

        /* Adjust dynamic margins for larger screens */
    @media (min-width: 576px) {
      .content-wrapper {
        margin-left: 0px;
        margin-right: 0px;
      }
    }

    @media (min-width: 768px) {
      .content-wrapper {
        margin-left: 30px;
        margin-right: 30px;
      }
    }

    @media (min-width: 992px) {
      .content-wrapper {
        margin-left: 50px;
        margin-right: 50px;
      }
    }
    /* Card adjustments for spacing */
    .card {
      margin-bottom: 20px;
    }
        /* Hover effect for the logout button */
        .logout-btn {
        padding: 10px;
        transition: transform 0.2s ease, color 0.2s ease, background-color 0.2s ease; /* Include background-color for smooth transition */
        border-radius: 5px; /* Adjust the value to change how round the corners are */
    }

    /* Hover effect */
    .logout-btn:hover {
        background-color: #2D3749FF; /* Change color on hover */
        transform: scale(1.05); /* Optional: Slightly enlarge on hover */
    }

    .course-card {
        cursor: pointer; /* Change cursor to pointer on hover */
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .course-card.selected-card {
        background-color: #007bff; /* Highlight color */
        color: white; /* Text color change */
    }

    .course-card.selected-card .form-check-input {
        display: none; /* Hide the default radio button */
    }
    .disabled {
    opacity: 0.5; /* Make the card appear greyed out */
    pointer-events: none; /* Disable any interactions with the card */
    background-color: #f8f9fa; /* Optional: Change background to a lighter color */
    }

  </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/aces.png') }}" alt="Logo" width="50" height="50" class="me-2">
                <strong class="d-none d-sm-inline">TeamAces Student Portal</strong> <!-- Hide text on small screens -->
            </a>
            <div class="d-flex ms-auto"> <!-- Use d-flex to align logout button to the right -->
                <form action="{{ route('student.logout') }}" method="POST" id="logout-form" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link text-white logout-btn" style="border: none; background: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>

  <!-- Main Content -->
  <div class="mt-4 content-wrapper">
    <div id="form-container" class="container">
        <h2 class="mb-4"><strong>Select New Course</strong></h2>

<!-- Start of the form -->
<form id="enrollment-form" onsubmit="submitForm(event)">
    <input type="hidden" name="student_id" value="{{ auth()->guard('student')->id() }}">
    @csrf <!-- CSRF token for Laravel form submission security -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Course Selection Field -->
    <div class="mb-3">
        <label class="form-label">Course</label>
        <div class="row">
            @foreach($courses as $course)
                @if(!in_array($course->acronym, ['TDC', 'OTDC'])) <!-- Check to exclude TDC and OTDC -->
                    <div class="col-md-4 mb-3"> <!-- Adjust the column size as needed -->
                        <div class="card course-card {{ in_array($course->id, $studentCourses) ? 'disabled' : '' }}"
                             onclick="{{ in_array($course->id, $studentCourses) ? '' : "selectCourse('course_{$course->id}')" }}">
                            <div class="card-body">
                                <input type="radio" id="course_{{ $course->id }}" name="course_id" value="{{ $course->id }}"
                                       class="form-check-input" required style="display: none;"
                                       {{ in_array($course->id, $studentCourses) ? 'disabled' : '' }}>
                                <label for="course_{{ $course->id }}" class="form-check-label">
                                    <h5 class="card-title">{{ $course->name }}</h5>
                                    <p class="card-text">₱{{ number_format($course->price, 2) }}</p>
                                    @if(in_array($course->id, $studentCourses))
                                        <p class="text-muted">You are already enrolled in this course.</p>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>


    <!-- Submit Button -->
    <div class="button-container">
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </div>
</form>



    </div>

</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Add this JavaScript to handle card selection -->
<!-- Add this JavaScript to handle card selection -->
<script>
    function selectCourse(courseId) {
        // Deselect all radio buttons and remove highlight from all cards
        const cards = document.querySelectorAll('.course-card');
        const radios = document.querySelectorAll('input[type="radio"]');

        cards.forEach(card => {
            card.classList.remove('selected-card');
        });

        radios.forEach(radio => {
            radio.checked = false;
        });

        // Select the clicked radio button and highlight the card
        const selectedCard = document.getElementById(courseId);
        selectedCard.checked = true;
        selectedCard.closest('.course-card').classList.add('selected-card');
    }

// Set up CSRF token for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function submitForm(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the selected course ID
    const selectedCourseId = document.querySelector('input[name="course_id"]:checked').value;

    // Check if the user is already enrolled in the selected course
    const enrolledCourses = {!! json_encode($studentCourses) !!}; // Pass the PHP variable to JS

    if (enrolledCourses.includes(parseInt(selectedCourseId))) {
        Swal.fire({
            title: 'Error!',
            text: 'You are already enrolled in this course.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Exit the function if already enrolled
    }

    // Prepare the data to send
    const data = {
        course_id: selectedCourseId,
        is_package: 0,
        has_permit: 1,
        is_approved: 0,
        status: 'pending',
    };

    // Make the AJAX request
    $.ajax({
        url: '{{ route('existing-enrollment.store') }}', // Update with your store route
        method: 'POST',
        data: data,
        success: function(response) {
            // Display success message with SweetAlert
            Swal.fire({
                title: 'Success!',
                text: 'You have successfully enrolled in the course. Please contact or go to your branch for the payment.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                                // Redirect to the previous view after confirmation
                                window.location.href = '{{ route('student.dashboard') }}';
                            });
        },
        error: function(xhr) {
            // Display error message with SweetAlert
            Swal.fire({
                title: 'Error!',
                text: xhr.responseJSON.message || 'Something went wrong.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}


</script>
</body>
</html>

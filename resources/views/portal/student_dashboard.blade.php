<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TeamAces Student Portal</title>
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
    <div class="mb-3">
        <h3>Welcome, <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>!</h3> <!-- Welcome message -->
    </div>
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2><strong>My Courses</strong></h2>
        <a href="{{ route('requests.made') }}" class="btn btn-primary">
            <i class="bi bi-file-earmark-text"></i>
            View Requests</a> <!-- Button to view requests -->
    </div>
    <div class="row">
        @foreach($courses as $studentCourse) <!-- Change $course to $studentCourse -->
        <div class="col-md-4">
            <a href="{{ route('course.details', ['id' => $studentCourse->id]) }}" class="text-decoration-none text-dark">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $studentCourse->name }} ({{ $studentCourse->acronym }})</h5>
                        <p class="card-text">{{ $studentCourse->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Sessions: {{ $studentCourse->number_of_sessions }}</li>
                            <li class="list-group-item">Hours per session: {{ $studentCourse->hours_per_session }}</li>
                            <li class="list-group-item">Price: ₱{{ number_format($studentCourse->price, 2) }}</li>
                            <li class="list-group-item">Status: {{ $studentCourse->status }}</li>
                        </ul>
                        <!-- Progress Bar -->
                        <div class="mt-3">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $studentCourse->completion_percentage }}%;" aria-valuenow="{{ $studentCourse->completion_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ number_format($studentCourse->completion_percentage, 0) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

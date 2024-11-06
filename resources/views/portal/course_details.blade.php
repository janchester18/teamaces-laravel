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


    /* Set a specific width for the Actions column */
    .actions-column {
        width: 200px;
    }

        /* Hover effect for the logout button */
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

    <div class="content-wrapper mt-4">
        <!-- Back Button -->
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>

        <h2><strong>{{ $course->name }} ({{ $course->acronym }})</strong></h2>
        <p>{{ $course->description }}</p>

        <h4>Schedules</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Scheduled Date</th>
                        <th>Finish Time</th>
                        <th>Status</th>
                        <th class="actions-column">Actions</th> <!-- Add class here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->scheduled_date }}</td>
                            <td>{{ $schedule->schedule_finish }}</td>
                            <td>{{ $schedule->status }}</td>
                            <td>
                                @if($schedule->status !== 'done')
                                    <form action="{{ route('request.adjustment') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <input type="hidden" name="scheduled_date" value="{{ $schedule->scheduled_date }}">
                                        <input type="hidden" name="schedule_finish" value="{{ $schedule->schedule_finish }}">
                                        <input type="hidden" name="status" value="{{ $schedule->status }}">
                                        <input type="hidden" name="branch_id" value="{{ $schedule->branch_id }}">
                                        <button type="submit" class="btn btn-warning btn-sm action-button">
                                            <i class="bi bi-pencil-fill"></i> Request Adjustment
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

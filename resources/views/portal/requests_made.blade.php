<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamAces Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
        .logout-btn {
            padding: 10px;
            transition: transform 0.2s ease, color 0.2s ease, background-color 0.2s ease;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #2D3749FF;
            transform: scale(1.05);
        }

        /* FullCalendar style adjustments */
        #calendar {
            margin: 40px auto;
        }
        /* Custom styles for FullCalendar */
        .fc {
            font-family: 'Arial', sans-serif; /* Modern font */
        }

        /* Change the background color and text color of the header */
        .fc-toolbar {
            background-color: #343a40; /* Dark background */
            color: #ffffff; /* White text */
            padding: 10px;
            border-radius: 5px;
        }

        /* Style the title of the calendar */
        .fc-toolbar h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        /* Style for the calendar day cells */
        .fc-daygrid-day {
            border: 1px solid #dee2e6; /* Light border */
        }

        /* Change hover effect for days */
        .fc-daygrid-day:hover {
            background-color: #f8f9fa; /* Light background on hover */
        }

        /* Style the events */
        /* Remove hover effects from FullCalendar events */
        .fc-event {
            color: #000000;
            transition: none !important; /* Disable transitions */
            cursor: default; /* Change cursor to default */
        }



        /* Style for selected days in the month view */
        .fc-daygrid-day.fc-day-today {
            background-color: #e9ecef; /* Highlight today */
        }

        .fc-toolbar-chunk button {
            background-color: #e9ecef !important;
            color: #343a40 !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/aces.png') }}" alt="Logo" width="50" height="50" class="me-2">
                <strong class="d-none d-sm-inline">TeamAces Student Portal</strong>
            </a>
            <div class="d-flex ms-auto">
                <form action="{{ route('student.logout') }}" method="POST" id="logout-form" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link text-white logout-btn" style="border: none; background: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
                <!-- Back Button -->
                <a href="{{ route('student.dashboard') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
        <h2><strong>Requests Made</strong></h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Current Scheduled Date</th>
                        <th>New Scheduled Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($request->schedule)->scheduled_date }}</td>
                            <td>{{ $request->new_scheduled_date }}</td>
                            <td>{{ $request->status ? ucfirst($request->status) : 'N/A' }}</td>
                            <td>{{ $request->reason ?: 'N/A' }}</td>
                            <td>{{ $request->created_at }}</td>
                            <td>{{ $request->updated_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No requests made.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

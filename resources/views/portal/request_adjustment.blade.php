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

    <div class="content-wrapper mt-4">
        <!-- Back Button -->
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>

        <!-- Full Calendar -->
        <div id="calendar"></div>

        <div class="mb-5">
            <h3>Request Schedule Adjustment</h3>

            <!-- Display current schedule details -->
            <div class="mb-3">
                <strong>Current Scheduled Date:</strong> {{ $scheduledDate }}<br>
                <strong>Finish Time:</strong> {{ $scheduleFinish }}<br>
                <strong>Status:</strong> {{ ucfirst($status) }}<br>
            </div>

            <!-- Form to select new schedule -->
            <form id="adjustmentForm" action="{{ route('submit.adjustment') }}" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $scheduleId }}">
                <!-- Date and Time Picker for new schedule -->
                <div class="mb-3">
                    <label for="new_schedule" class="form-label">Select New Start Date and Time</label>
                    <input type="datetime-local" name="new_schedule" class="form-control" id="newSchedule" required>
                </div>
                <!-- Calculated Finish Time -->
                <div class="mb-3">
                    <label for="new_schedule_finish" class="form-label">Calculated Finish Time</label>
                    <input type="datetime-local" name="new_schedule_finish" class="form-control" id="newScheduleFinish" readonly>
                    <input type="hidden" name="branch_id" value="{{ $schedule->branch_id }}">
                    <input type="hidden" name="course_id" value="{{ $schedule->course_id }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Adjustment Request</button>
                </div>
            </form>


        </div>


        <!-- Modal to display schedule events -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Scheduled Classes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Modal table structure -->
                        <!-- Modal table structure -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Time</th>
                                        <th>Course</th>
                                    </tr>
                                </thead>
                                <tbody id="eventDetailsTableBody">
                                    <!-- Event details will be injected here by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Global variables
        var eventMap = new Map();
        var calendar; // Declare calendar in the global scope

        document.addEventListener('DOMContentLoaded', function() {
            // Group events by date
            var eventsByDate = {};

            @foreach ($schedules as $schedule)
            @if ($schedule->course_id != 1 && $schedule->course_id != 2)
                    <?php
                    // Extracting the date without the time part
                    $date = \Carbon\Carbon::parse($schedule->scheduled_date)->toDateString();
                    ?>
                    // Add event to the respective date
                    eventsByDate['{{ $date }}'] = eventsByDate['{{ $date }}'] || [];
                    var eventObj = {
                        title: '{{ $schedule->student ? $schedule->student->first_name : 'N/A' }} {{ $schedule->student ? $schedule->student->last_name : 'N/A' }} - {{ $schedule->course ? $schedule->course->acronym : 'N/A' }}',
                        start: '{{ $schedule->scheduled_date }}',
                        end: '{{ $schedule->schedule_finish }}',
                        id: '{{ $schedule->id }}', // Add schedule ID for updates
                        extendedProps: {
                            student: '{{ $schedule->student ? $schedule->student->first_name : 'N/A' }} {{ $schedule->student ? $schedule->student->last_name : 'N/A' }}',
                            course: '{{ $schedule->course ? $schedule->course->acronym : 'N/A' }}',
                            time: '{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->schedule_finish)->format('h:i A') }}',
                            status: '{{ $schedule->status }}' // Include current status
                        }
                    };
                    eventsByDate['{{ $date }}'].push(eventObj);
                    eventMap.set('{{ $schedule->id }}', eventObj); // Store event in the map
                @endif
            @endforeach

            // Flatten the events for FullCalendar
            var events = [];
            for (const [date, dayEvents] of Object.entries(eventsByDate)) {
                const displayedEvents = dayEvents.slice(0, 3); // Get the first 3 events
                events.push(...displayedEvents);

                if (dayEvents.length > 3) {
                    // Add a "more+" event if there are more than 3
                    events.push({
                        title: `+${dayEvents.length - 3} more`,
                        start: date,
                        allDay: true
                    });
                }
            }

            // Initialize FullCalendar
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                events: events,
                dateClick: function(info) {
                    // Show all events for the clicked date
                    var eventDetailsTableBody = $('#eventDetailsTableBody');
                    eventDetailsTableBody.empty();

                    // Retrieve all events for the clicked date
                    const allEventsForTheDay = eventsByDate[info.dateStr] || [];

                    if (allEventsForTheDay.length) {
                        allEventsForTheDay.forEach(event => {
                            const student = event.extendedProps?.student || "N/A";
                            const phone = event.extendedProps?.phone || "N/A";
                            const course = event.extendedProps?.course || "N/A";
                            const time = event.extendedProps?.time || "N/A";

                            eventDetailsTableBody.append(`
                                <tr>
                                    <td>${student}</td>
                                    <td>${time}</td>
                                    <td>${course}</td>
                                </tr>
                            `);
                        });

                    } else {
                        eventDetailsTableBody.append(`
                    <tr>
                        <td colspan="5" class="text-center">No scheduled classes for this day.</td>
                    </tr>
                `);
                    }

                    var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModal.show();
                }
            });

            calendar.render();
        });


        document.getElementById('newSchedule').addEventListener('change', function() {
    const startDateTime = new Date(this.value); // Get the selected start date and time
    const hoursPerSession = {{ $hoursPerSession }}; // Get hours per session from PHP

    // Calculate the finish time
    startDateTime.setHours(startDateTime.getHours() + hoursPerSession + 8);

    // Format the finish time to datetime-local format
    const finishDateTime = startDateTime.toISOString().slice(0, 16);

    // Set the calculated finish time in the readonly input
    document.getElementById('newScheduleFinish').value = finishDateTime;
});



$(document).ready(function() {
    $('#adjustmentForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit the schedule adjustment request?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Check if the response contains success message
                        if (response.success) {
                            // Show success message
                            Swal.fire(
                                'Submitted!',
                                'Your schedule adjustment request has been submitted.',
                                'success'
                            ).then(() => {
                                // Redirect to the previous view after confirmation
                                window.location.href = '{{ route('student.dashboard') }}';
                            });
                        } else {
                            // Handle any server-side errors or validation issues
                            Swal.fire(
                                'Error!',
                                response.message || 'There was an issue submitting your request.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        // Show error message for failed request
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.message || 'There was a problem submitting your request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
    </script>

</body>

</html>

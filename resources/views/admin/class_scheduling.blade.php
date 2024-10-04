<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Scheduling</title>
    <!-- Font Awesome 6.4.0 CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.0 CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css">



    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-dark sidebar">
                <div class="logo-container text-center pt-4">
                    <img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo" class="sidebar-logo">
                </div>

                <!-- User Info -->
                <div class="user-info text-center text-light">
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="mb-2">{{ Auth::user()->branch ? Auth::user()->branch->name : 'No Branch Assigned' }}</p>
                    <p>{{ ucfirst(strtolower(Auth::user()->role)) }}</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('branch_analytics') }}"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('class_scheduling') }}"><i class="fas fa-calendar-check"></i> Class Scheduling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('student_management') }}"><i class="fas fa-user-graduate"></i> Student Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('pending_enrollments') }}"><i class="fas fa-user-plus"></i> Pending Enrollments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-light" href="{{ route('reports') }}"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('settings') }}"><i class="fas fa-cogs"></i> Settings</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link text-light btn btn-link logout-btn" style="border: none;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Nav -->
                <header class="d-flex justify-content-between align-items-center py-3">
                    <h2>Class Scheduling</h2>
                    <div class="profile d-flex align-items-center">
                        <!-- Notification Icon -->
                        <a href="#" class="text-dark me-3">
                            <i class="fas fa-bell"></i>
                        </a>
                        <!-- Profile Icon -->
                        <a href="#" class="text-dark">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                    </div>
                </header>

                <!-- Full Calendar -->
                <!-- Full Calendar -->
                <div id="calendar"></div>

                <!-- Modal to display schedule events -->
                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel">Scheduled Classes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul id="eventDetails" class="list-group">
                                    <!-- Event details will be injected here by JS -->
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Class Scheduling -->
                <section class="class-overview my-4">
                    <h4>Overview of Scheduled Classes</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student Name</th>
                                    <th>Course Acronym</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody id="classOverviewBody">
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('Y-m-d') }}</td>
                                        <td>{{ $schedule->student ? $schedule->student->first_name : 'N/A' }} {{ $schedule->student ? $schedule->student->last_name : 'N/A' }}</td>
                                        <td>{{ $schedule->course ? $schedule->course->acronym : 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->schedule_finish)->format('h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>

   <!-- Bootstrap JS CDN -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <!-- FullCalendar JS -->
   <script src="
https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js
"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Group events by date
        var eventsByDate = {};

        @foreach ($schedules as $schedule)
            @if ($schedule->course_id != 1) <!-- Check if course_id is not equal to 1 -->
                <?php
                    // Extracting the date without the time part
                    $date = \Carbon\Carbon::parse($schedule->scheduled_date)->toDateString();
                ?>
                // Add event to the respective date
                eventsByDate['{{ $date }}'] = eventsByDate['{{ $date }}'] || [];
                eventsByDate['{{ $date }}'].push({
                    title: '{{ $schedule->student ? $schedule->student->first_name : "N/A" }} {{ $schedule->student ? $schedule->student->last_name : "N/A" }} - {{ $schedule->course ? $schedule->course->acronym : "N/A" }}',
                    start: '{{ $schedule->scheduled_date }}',
                    end: '{{ $schedule->schedule_finish }}',
                    extendedProps: { // Ensure extendedProps is defined
                        student: '{{ $schedule->student ? $schedule->student->first_name : "N/A" }} {{ $schedule->student ? $schedule->student->last_name : "N/A" }}',
                        course: '{{ $schedule->course ? $schedule->course->acronym : "N/A" }}',
                        time: '{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format("h:i A") }} - {{ \Carbon\Carbon::parse($schedule->schedule_finish)->format("h:i A") }}'
                    }
                });
            @endif
        @endforeach

        // Flatten the events for FullCalendar, limiting to 3 events per date and adding "more+" if necessary
        var events = [];
        for (const [date, dayEvents] of Object.entries(eventsByDate)) {
            const displayedEvents = dayEvents.slice(0, 3); // Get the first 3 events
            events.push(...displayedEvents); // Add the first 3 events

            if (dayEvents.length > 3) {
                // Add a "more+" event if there are more than 3
                events.push({
                    title: `+${dayEvents.length - 3} more`,
                    start: date,
                    allDay: true // This makes it a full-day event
                });
            }
        }

        // Initialize FullCalendar
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            events: events,
            dateClick: function (info) {
                // Log the clicked date
                console.log('Clicked date:', info.dateStr);

                // Show all events for the clicked date
                var eventDetails = $('#eventDetails');
                eventDetails.empty();

                // Retrieve all events for the clicked date
                const allEventsForTheDay = eventsByDate[info.dateStr] || [];

                if (allEventsForTheDay.length) {
                    allEventsForTheDay.forEach(event => {
                        // Ensure extendedProps is defined before accessing its properties
                        const student = event.extendedProps?.student || "N/A";
                        const course = event.extendedProps?.course || "N/A";
                        const time = event.extendedProps?.time || "N/A";
                        eventDetails.append(`<li class="list-group-item">${student} (${time}) - ${course}</li>`);
                    });
                } else {
                    eventDetails.append('<li class="list-group-item">No scheduled classes for this day.</li>');
                }

                var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            }
        });

        calendar.render();
    });
</script>



</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Class Scheduling</title>
    <!-- Font Awesome 6.4.0 CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.0 CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                        <a class="nav-link text-light" href="{{ route('admin.branch_analytics_view') }}"><i class="fas fa-home"></i> Dashboard</a>
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
                                            <th>Phone Number</th>
                                            <th>Time</th>
                                            <th>Course</th>
                                            <th>Status</th> <!-- New Status column -->
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


                <!-- Class Scheduling -->
                <section class="class-overview my-4">
                    <h4>Overview of Scheduled TDC Classes</h4>
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
                                    @if ($schedule->course && $schedule->course->acronym === 'TDC' && $schedule->status !== 'done')
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('Y-m-d') }}</td>
                                            <td>{{ $schedule->student ? $schedule->student->first_name : 'N/A' }} {{ $schedule->student ? $schedule->student->last_name : 'N/A' }}</td>
                                            <td>{{ $schedule->course->acronym }}</td>
                                            <td>{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->schedule_finish)->format('h:i A') }}</td>
                                        </tr>
                                    @endif
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
   <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
   <!-- SweetAlert2 JS -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


   <script>
// Global variables
var eventMap = new Map();
var calendar; // Declare calendar in the global scope

document.addEventListener('DOMContentLoaded', function () {
    // Group events by date
    var eventsByDate = {};

    @foreach ($schedules as $schedule)
        @if ($schedule->course_id != 1) // Check if course_id is not equal to 1
            <?php
                // Extracting the date without the time part
                $date = \Carbon\Carbon::parse($schedule->scheduled_date)->toDateString();
            ?>
            // Add event to the respective date
            eventsByDate['{{ $date }}'] = eventsByDate['{{ $date }}'] || [];
            var eventObj = {
                title: '{{ $schedule->student ? $schedule->student->first_name : "N/A" }} {{ $schedule->student ? $schedule->student->last_name : "N/A" }} - {{ $schedule->course ? $schedule->course->acronym : "N/A" }}',
                start: '{{ $schedule->scheduled_date }}',
                end: '{{ $schedule->schedule_finish }}',
                id: '{{ $schedule->id }}', // Add schedule ID for updates
                extendedProps: {
                    student: '{{ $schedule->student ? $schedule->student->first_name : "N/A" }} {{ $schedule->student ? $schedule->student->last_name : "N/A" }}',
                    phone: '{{ $schedule->student ? $schedule->student->phone_number : "N/A" }}',
                    course: '{{ $schedule->course ? $schedule->course->acronym : "N/A" }}',
                    time: '{{ \Carbon\Carbon::parse($schedule->scheduled_date)->format("h:i A") }} - {{ \Carbon\Carbon::parse($schedule->schedule_finish)->format("h:i A") }}',
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
        dateClick: function (info) {
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
                    const status = event.extendedProps?.status || "N/A"; // Get status

                    eventDetailsTableBody.append(`
                        <tr>
                            <td>${student}</td>
                            <td>${phone}</td>
                            <td>${time}</td>
                            <td>${course}</td>
                            <td>
                                <select class="form-select" onchange="updateScheduleStatus(${event.id}, this.value)">
                                    <option value="pending" ${status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="done" ${status === 'done' ? 'selected' : ''}>Done</option>
                                    <option value="missed" ${status === 'missed' ? 'selected' : ''}>Missed</option>
                                </select>
                            </td>
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

function updateScheduleStatus(scheduleId, status) {
    $.ajax({
        url: `/schedules/${scheduleId}/update`, // Define your route for updating schedule
        method: 'PUT',
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Status Updated',
                text: 'Schedule status has been updated successfully!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload(); // Reload the page after the success message is dismissed
            });

            // Get the event by ID and update it directly
            const eventToUpdate = eventMap.get(scheduleId);
            if (eventToUpdate) {
                eventToUpdate.extendedProps.status = status; // Update the status in extendedProps

                // Update the calendar event title to reflect the new status
                calendar.getEventById(scheduleId)?.setProp('title', `${eventToUpdate.extendedProps.student} - ${eventToUpdate.extendedProps.course} (${status})`);

                // If the status is "done", remove it from the calendar
                if (status === 'done') {
                    calendar.getEventById(scheduleId)?.remove(); // Remove from calendar
                    eventMap.delete(scheduleId); // Remove from the map
                }
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'There was an error updating the schedule status.',
                showConfirmButton: true
            });
        }
    });
}


</script>

</body>

</html>

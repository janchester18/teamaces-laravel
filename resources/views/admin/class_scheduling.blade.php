<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Branch Analytics</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
        <!-- Bootstrap 5.3.0 CDN link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader (optional) -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images/admin/aceslogo.png') }}" alt="AdminLTE Logo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell"></i>
                    </a>
                </li>
                <!-- User Profile -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.branch_analytics_view') }}" class="brand-link">
                <img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">TeamAces</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- User Panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        <small>{{ ucfirst(strtolower(Auth::user()->role)) }} -
                            {{ Auth::user()->branch ? Auth::user()->branch->name : 'No Branch Assigned' }}</small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.branch_analytics_view') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('class_scheduling') }}" class="nav-link active">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Class Scheduling</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student_management') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Student Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pending_enrollments') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Pending Enrollments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule_adjustment_requests') }}" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Schedule Adjustment Requests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Reports & Analytics</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings') }}" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link logout-btn">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Logout</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
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
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
        </div>
        <strong>Copyright &copy; 2024 TeamAces Driving Academy.</strong> All rights reserved.
    </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
       <!-- FullCalendar JS -->
   <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/branch_analytics.js') }}"></script>
    <script>
        src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" >
    </script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

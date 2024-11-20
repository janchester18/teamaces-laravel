<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Schedule</title>
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
                            {{ Auth::user()->branch ? str_replace('TeamAces Driving Academy ', '', Auth::user()->branch->name) : 'No Branch Assigned' }}</small>
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
                            <a href="{{ route('class_scheduling') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Class Scheduling</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student_management') }}" class="nav-link active">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Student Management</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ request()->is('pending_enrollments*') /* || request()->is('existing_students*') */ ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Pending Enrollments
                                    <i class="right fas fa-angle-left"></i> <!-- Indicates that it's collapsible -->
                                </p>
                            </a>
                            <ul class="nav nav-treeview mt-0">
                                <li class="nav-item pl-3">
                                    <a href="{{ route('pending_enrollments') }}" class="nav-link {{ request()->routeIs('pending_enrollments') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>New Students</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-3">
                                    <a href="{{ route('existing_students') }}" class="nav-link {{-- {{ request()->routeIs('existing_students') ? 'active' : '' }} --}}">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Existing Students</p>
                                    </a>
                                </li>
                            </ul>
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
                            <h1 class="m-0">Edit Schedule</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <!-- "Back to Student Management" Button -->
            <div class="mx-3 mb-3">
                <a href="{{ route('student_management') }}" class="text-primary" style="text-decoration: underline;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Student Management
                </a>
            </div>

            <div class="container">
                <h2>Schedule for <strong>{{ $student->first_name }} {{ $student->last_name }}</strong></h2>

                @if ($schedules->isEmpty())
                    <div class="card text-center w-100">
                        <div class="card-body">
                            <i class="fas fa-frown fa-5x text-muted"></i>
                            <h5 class="card-title mt-3">Nothing to See Here!</h5>
                            <p class="card-text">There are currently no schedules for this student.</p>
                        </div>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Scheduled Date</th>
                                <th>Finish Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->scheduled_date }}</td>
                                    <td>{{ $schedule->schedule_finish }}</td>
                                    <td>{{ ucfirst($schedule->status) }}</td>
                                    <td class="actions">
                                        @if (strtolower($schedule->status) !== 'done')
                                            <!-- Check if status is not "done" -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editScheduleModal"
                                                data-schedule-id="{{ $schedule->id }}"
                                                data-course-hours="{{ $schedule->course->hours_per_session }}"
                                                data-date="{{ $schedule->scheduled_date }}"
                                                data-finish="{{ $schedule->schedule_finish }}">
                                                Edit
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @endif
            </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Schedule ID:</strong> <span id="scheduleId"></span></p>
                    <p><strong>Current Scheduled Date:</strong> <span id="scheduledDate"></span></p>
                    <p><strong>Current Finish Time:</strong> <span id="scheduleFinish"></span></p>

                    <!-- New Schedule Form -->
                    <form id="updateScheduleForm">
                        <div class="mb-3">
                            <label for="newStartDate" class="form-label">New Start Date and Time</label>
                            <input type="datetime-local" class="form-control" id="newStartDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="newFinishDate" class="form-label">Calculated Finish Time</label>
                            <input type="datetime-local" class="form-control" id="newFinishDate" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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
        // JavaScript to handle modal data
        const editScheduleModal = document.getElementById('editScheduleModal');
        editScheduleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Button that triggered the modal

            // Extract data from data-* attributes
            const scheduleId = button.getAttribute('data-schedule-id');
            const scheduledDate = button.getAttribute('data-date');
            const scheduleFinish = button.getAttribute('data-finish');
            const courseHours = button.getAttribute('data-course-hours');

            // Update the modal's content
            const scheduleIdElement = editScheduleModal.querySelector('#scheduleId');
            const scheduledDateElement = editScheduleModal.querySelector('#scheduledDate');
            const scheduleFinishElement = editScheduleModal.querySelector('#scheduleFinish');
            const newStartDateElement = editScheduleModal.querySelector('#newStartDate');
            const newFinishDateElement = editScheduleModal.querySelector('#newFinishDate');

            scheduleIdElement.textContent = scheduleId;
            scheduledDateElement.textContent = scheduledDate;
            scheduleFinishElement.textContent = scheduleFinish;

            // Reset the input fields
            newStartDateElement.value = ''; // Clear previous values
            newFinishDateElement.value = '';

            // Calculate finish date when new start date is inputted
            newStartDateElement.addEventListener('input', () => {
                const startDate = new Date(newStartDateElement.value);
                if (!isNaN(startDate) && courseHours) {
                    // Set the hours for finish date based on hours per session
                    const finishDate = new Date(startDate);
                    finishDate.setHours(finishDate.getHours() + parseInt(courseHours) + 8); // Add course hours to the start date
                    newFinishDateElement.value = finishDate.toISOString().slice(0, 16); // Format to datetime-local
                }
            });
        });

        // Handle form submission with confirmation and SweetAlert
        document.getElementById('updateScheduleForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Ask for confirmation before updating the schedule
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to update this schedule?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with the update
                    const scheduleId = document.getElementById('scheduleId').textContent;
                    const newStartDate = document.getElementById('newStartDate').value;
                    const newFinishDate = document.getElementById('newFinishDate').value;

                    fetch(`/schedules/${scheduleId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            scheduled_date: newStartDate,
                            schedule_finish: newFinishDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Updated!',
                                text: 'Schedule updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            // Display the error message returned from the backend
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to update schedule. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating schedule:', error);
                        Swal.fire({
                            title: 'Network Error!',
                            text: 'There was an issue connecting to the server. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });

                }
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule for {{ $student->first_name }} {{ $student->last_name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 CSS -->
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
                        <a href="#" class="text-dark me-3">
                            <i class="fas fa-bell"></i>
                        </a>
                        <a href="#" class="text-dark">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                    </div>
                </header>

                <!-- "Back to Student Management" Button -->
                <div class="mb-3">
                    <a href="{{ route('student_management') }}" class="text-primary" style="text-decoration: underline;">
                        <i class="fas fa-arrow-left me-2"></i>Back to Student Management
                    </a>
                </div>

                <div class="container">
                    <h2>Schedule for <strong>{{ $student->first_name }} {{ $student->last_name }}</strong></h2>

                    @if($schedules->isEmpty())
                        <div class="card text-center w-100">
                            <div class="card-body">
                                <i class="fas fa-frown fa-5x text-muted"></i>
                                <h5 class="card-title mt-3">Nothing to See Here!</h5>
                                <p class="card-text">There are currently no schedules for this student.</p>
                            </div>
                        </div>
                    @else
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
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->scheduled_date }}</td>
                                    <td>{{ $schedule->schedule_finish }}</td>
                                    <td>{{ ucfirst($schedule->status) }}</td>
                                    <td class="actions">
                                        @if(strtolower($schedule->status) !== 'done') <!-- Check if status is not "done" -->
                                            <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
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
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Include SweetAlert2 JS -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <!-- Font Awesome 6.4.0 CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.0 CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                <h5>{{ Auth::user()->name }}</h5> <!-- Display User's Name -->
                <p class="mb-2">{{ Auth::user()->branch ? Auth::user()->branch->name : 'No Branch Assigned' }}</p> <!-- Display Branch Name -->
                <p>{{ ucfirst(strtolower(Auth::user()->role)) }}</p> <!-- Display Role in Sentence Case -->
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
                            @csrf <!-- CSRF token for security -->
                            <button type="submit" class="nav-link text-light btn btn-link logout-btn" style="border: none;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                  </ul>
              </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 main-content">
                <header class="d-flex justify-content-between align-items-center py-3">
                    <h2>Student Management</h2>
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

<!-- Student List Section -->
<section class="student-list my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Sort Button on the left -->
        <button class="btn btn-secondary me-2">Sort</button>

        <!-- Search Bar in the middle -->
        <div class="flex-grow-1 mx-3">
            <input type="text" class="form-control" placeholder="Search by name" aria-label="Search" id="searchStudent">
        </div>

        <!-- Add Student Button on the right -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Courses</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                @foreach($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- Displays the row number -->
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td> <!-- Assuming you have 'first_name' and 'last_name' fields -->
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone_number }}</td>
                        <td>
                            @if($student->courses->isNotEmpty())
                                @foreach($student->courses as $course)
                                    {{ $course->name }}<br>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('students.show', ['student' => $student->id]) }}" class="btn btn-sm btn-primary">Edit Schedule</a>
                            <button class="btn btn-sm btn-warning">Update Progress</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
            </main>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        @csrf <!-- CSRF token for Laravel form submission security -->
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name" required>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone_number" placeholder="Enter phone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Active Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        </div>
                        <!-- Course Selection Field -->
                        <div class="mb-3">
                            <label for="course" class="form-label">Course</label>
                            <select class="form-select" id="course" name="course_id">
                                <option value="" selected>Select a course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->name }} - ₱{{ number_format($course->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Package Selection Field -->
                        <div class="mb-3">
                            <label for="package" class="form-label">Package</label>
                            <select class="form-select" id="package" name="package_id">
                                <option value="" selected>Select a package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}">
                                        {{ $package->name }} - ₱{{ number_format($package->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
<!-- Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Update Student Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalStudentInfo"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Scheduled Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="modalScheduleBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            </div>
        </div>
    </div>
</div>


    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('addStudentForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Create a FormData object from the form
    let formData = new FormData(this);

    // Send an AJAX request
    fetch("{{ route('students.store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Received Data:', data); // Log the received data

        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); // Reload the page after clicking OK
            });

            // Clear the form fields
            document.getElementById('addStudentForm').reset();

            // Close the modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('addStudentModal'));
            modal.hide();
        } else {
            console.error('Error from server:', data.message); // Log server error
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'There was an error processing your request.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});

document.getElementById('package').addEventListener('change', function() {
        var courseSelect = document.getElementById('course');

        // If a package is selected, clear the course selection
        if (this.value !== "") {
            courseSelect.selectedIndex = 0; // Reset to the default "Select a course" option
        }
    });

    document.getElementById('course').addEventListener('change', function() {
        var packageSelect = document.getElementById('package');

        // If a course is selected, clear the package selection
        if (this.value !== "") {
            packageSelect.selectedIndex = 0; // Reset to the default "Select a package" option
        }
    });


    $(document).ready(function () {
    $('.btn-warning').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Get the student ID (you can store it as a data attribute on the button)
        const studentId = $(this).closest('tr').find('td:nth-child(2)').text();

        // Optionally, you can retrieve student data from the table if needed
        const studentName = $(this).closest('tr').find('td:nth-child(3)').text();

        // Make an AJAX request to fetch the schedules for this student
        $.ajax({
            url: `/students/${studentId}/schedules`, // Define your route here
            method: 'GET',
            success: function (data) {
                // Check if data is valid
                if (!data || !Array.isArray(data) || data.length === 0) {
                    alert('No schedules found for this student.');
                    return; // Exit if data is not in expected format
                }

                // Populate the modal with student info (Assuming you have studentName available)
                $('#modalStudentInfo').html(`
                    <strong>Student ID:</strong> ${studentId} <br>
                    <strong>Name:</strong> ${studentName} <br>
                `);

                // Clear the schedule body
                $('#modalScheduleBody').empty();

                // Populate the schedule table
                data.forEach(schedule => {
                    $('#modalScheduleBody').append(`
                        <tr>
                            <td>${schedule.scheduled_date}</td>
                            <td>
                                <select class="form-control" onchange="updateScheduleStatus(${schedule.id}, this.value)">
                                    <option value="pending" ${schedule.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="done" ${schedule.status === 'done' ? 'selected' : ''}>Done</option>
                                    <option value="missed" ${schedule.status === 'missed' ? 'selected' : ''}>Missed</option>
                                </select>
                            </td>
                        </tr>
                    `);
                });

                // Show the modal
                $('#updateProgressModal').modal('show');
            },
            error: function () {
                alert('Error retrieving student schedules.');
            }
        });
    });
});

// Function to update schedule status
function updateScheduleStatus(scheduleId, status) {
    // Make an AJAX request to update the schedule status
    $.ajax({
        url: `/schedules/${scheduleId}/update`, // Define your route for updating schedule
        method: 'PUT',
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token here
        },
        success: function () {
            Swal.fire({
                icon: 'success',
                title: 'Status Updated',
                text: 'Schedule status has been updated successfully!',
                showConfirmButton: false,
                timer: 1500
            });
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

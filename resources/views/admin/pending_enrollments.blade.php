<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <!-- Font Awesome 6.4.0 CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.0 CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <header class="d-flex justify-content-between align-items-center py-3">
                    <h2>Pending Enrollments</h2>
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
                <!-- Pending Enrollments Table -->

                <section class="pending-enrollments my-4">
                    <div class="table-responsive">
                        @if($pendingEnrollments->isEmpty())
                            <div class="card text-center w-100">
                                <div class="card-body">
                                    <i class="fas fa-frown fa-5x text-muted"></i>
                                    <h5 class="card-title mt-3">Nothing to See Here!</h5>
                                    <p class="card-text">There are currently no pending enrollments.</p>
                                </div>
                            </div>
                        @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Course/Package</th> <!-- Combined column -->
                                    <th>Price</th> <!-- Price column -->
                                    <th>Enrolled on</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingEnrollments as $enrollment)
                                <tr>
                                    <td>{{ $enrollment->id }}</td>
                                    <td>{{ $enrollment->first_name }} {{ $enrollment->last_name }}</td>
                                    <td>
                                        @if($enrollment->course)
                                            {{ $enrollment->course->name }} (Course)
                                        @elseif($enrollment->package)
                                            {{ $enrollment->package->name }} (Package)
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($enrollment->course)
                                            {{ number_format($enrollment->course->price, 2) }} <!-- Display course price -->
                                        @elseif($enrollment->package)
                                            {{ number_format($enrollment->package->price, 2) }} <!-- Display package price -->
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $enrollment->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="actions">
                                        <button class="btn btn-sm btn-success" onclick="confirmPayment('{{ $enrollment->id }}')">Confirm Payment</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteEnrollment('{{ $enrollment->id }}')">Delete Enrollment</button> <!-- Delete button -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Confirmation and Payment Logic -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->

<script>
    function confirmPayment(studentId) {
        Swal.fire({
            title: 'Confirm Payment',
            text: "Are you sure you want to confirm this payment and add the student to the database?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request to confirm payment
                $.ajax({
                    url: '/confirm-payment/' + studentId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    success: function(response) {
                        Swal.fire(
                            'Confirmed!',
                            response.message,
                            'success'
                        );
                        // Optionally, reload the page or remove the row from the table
                        location.reload(); // Reload the page to refresh the table
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.message || 'Something went wrong.',
                            'error'
                        );
                    }
                });
            } else {
                Swal.fire(
                    'Cancelled',
                    'Payment confirmation cancelled.',
                    'error'
                );
            }
        });
    }

    function deleteEnrollment(enrollmentId) {
    Swal.fire({
        title: 'Delete Enrollment',
        text: "Are you sure you want to delete this enrollment?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make AJAX request to delete the enrollment
            $.ajax({
                url: '/enrollments/' + enrollmentId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    );
                    // Optionally reload the page or remove the row from the table
                    location.reload(); // Reload the page to refresh the table
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON.message || 'Something went wrong.',
                        'error'
                    );
                }
            });
        } else {
            Swal.fire(
                'Cancelled',
                'Enrollment deletion cancelled.',
                'error'
            );
        }
    });
}
</script>

</body>
</html>

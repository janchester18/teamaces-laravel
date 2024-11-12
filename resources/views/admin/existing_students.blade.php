<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Existing Student Enrollments</title>
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
                            <a href="{{ route('student_management') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Student Management</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview {{ /* request()->is('pending_enrollments*') || */ request()->is('existing_students*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Pending Enrollments
                                    <i class="right fas fa-angle-left"></i> <!-- Indicates that it's collapsible -->
                                </p>
                            </a>
                            <ul class="nav nav-treeview mt-0">
                                <li class="nav-item pl-3">
                                    <a href="{{ route('pending_enrollments') }}" class="nav-link {{-- {{ request()->routeIs('pending_enrollments') ? 'active' : '' }} --}}">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>New Students</p>
                                    </a>
                                </li>
                                <li class="nav-item pl-3">
                                    <a href="{{ route('existing_students') }}" class="nav-link  {{ request()->routeIs('existing_students') ? 'active' : '' }}">
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
                            <h1 class="m-0">Existing Student Enrollments</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

<!-- Main content -->
<!-- Main content -->
<section class="existing-students m-4">
    <div class="table-responsive">
        @if($notApprovedCourses->isEmpty())
        <div class="card text-center w-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-frown fa-5x text-muted"></i>
                <h5 class="card-title mt-3">Nothing to See Here!</h5>
                <p class="card-text">There are currently no existing students with pending approvals.</p>
            </div>
        </div>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course/Package</th>
                    <th>Is Package</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notApprovedCourses as $enrollment)
                <tr>
                    <td>{{ $enrollment->student->id }}</td>
                    <td>{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</td>
                    <td>{{ $enrollment->course->name ?? 'N/A' }}</td>
                    <td>{{ $enrollment->is_package ? 'Yes' : 'No' }}</td>
                    <td>{{ $enrollment->course->price ?? 'N/A' }}</td>
                    <td class="actions">
                        <button class="btn btn-sm btn-success" onclick="approveEnrollment('{{ $enrollment->id }}')">Approve</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteEnrollment('{{ $enrollment->id }}')">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</section>


<!-- /.content -->

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
function approveEnrollment(enrollmentId) {
    Swal.fire({
        title: 'Approve Enrollment',
        text: "Are you sure you want to approve this enrollment?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Prompt for the amount paid
            Swal.fire({
                title: 'Enter Amount Paid',
                input: 'number',
                inputLabel: 'Amount Paid',
                inputPlaceholder: 'Enter the amount paid',
                showCancelButton: true,
                confirmButtonText: 'Approve and Pay',
                cancelButtonText: 'Cancel',
                preConfirm: (amountPaid) => {
                    if (!amountPaid || amountPaid <= 0) {
                        Swal.showValidationMessage('Please enter a valid amount');
                        return false;
                    }
                    return amountPaid;
                }
            }).then((amountResult) => {
                if (amountResult.isConfirmed) {
                    // Make AJAX request to approve the enrollment and pass the amount paid
                    $.ajax({
                        url: '/approve-enrollment/' + enrollmentId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            amount_paid: amountResult.value // Include the amount paid in the data
                        },
                        success: function(response) {
                            Swal.fire(
                                'Approved!',
                                response.message,
                                'success'
                            );
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
                }
            });
        } else {
            Swal.fire(
                'Cancelled',
                'Enrollment approval cancelled.',
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
                url: '/delete-enrollments/' + enrollmentId, // Make sure the enrollmentId is correct here
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

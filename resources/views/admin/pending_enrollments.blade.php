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
                        <li class="nav-item">
                            <a href="{{ route('pending_enrollments') }}" class="nav-link active">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Pending Enrollments</p>
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
                            <h1 class="m-0">Pending Enrollments</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="pending-enrollments m-4">
                <div class="table-responsive">
                    @if($pendingEnrollments->isEmpty())
                    <div class="card text-center w-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
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

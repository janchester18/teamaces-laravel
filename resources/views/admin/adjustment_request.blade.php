<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Schedule Adjustment Requests</title>
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
                            <a href="{{ route('schedule_adjustment_requests') }}" class="nav-link active">
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
                <h1 class="m-0">Schedule Adjustment Requests</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end"> <!-- Use justify-content-end to align the button right -->
                <a href="{{ route('requests.log.data') }}" class="btn btn-primary rounded">
                    <i class="fas fa-list mr-1"></i>
                    Requests Log</a> <!-- Use rounded-pill for rounded corners -->
            </div>
        </div>
    </div>
</div>

            <!-- /.content-header -->

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    @if($requests->isEmpty())
                    <div class="card text-center w-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-frown fa-5x text-muted"></i>
                            <h5 class="card-title mt-3">Nothing to See Here!</h5>
                            <p class="card-text">There are currently no pending requests.</p>
                        </div>
                    </div>
                    @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Schedule ID</th>
                                <th>Current Scheduled Date</th>
                                <th>New Scheduled Date</th>
                                <th>Status</th>
                                <th>Action</th> <!-- New Action Column -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($request->schedule->student)->first_name ?? 'N/A' }} {{ optional($request->schedule->student)->last_name ?? 'N/A' }}</td>
                                    <td>{{ $request->schedule_id }}</td>
                                    <td>{{ optional($request->schedule)->scheduled_date }}</td>
                                    <td>{{ $request->new_scheduled_date }}</td>
                                    <td>{{ $request->status ?: 'Not processed yet' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" title="Process Request"
                                                data-bs-toggle="modal" data-bs-target="#processModal"
                                                onclick="populateModal({{ json_encode($request) }})">
                                            <i class="fas fa-cog"></i> Process
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No requests made.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="processModal" tabindex="-1" aria-labelledby="processModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="processModalLabel">Process Adjustment Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="processForm" action="{{ route('process.adjustment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="request_id" id="request_id">
                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="schedule_id" class="form-label">Schedule ID</label>
                        <input type="text" class="form-control" id="schedule_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="current_scheduled_date" class="form-label">Current Scheduled Date</label>
                        <input type="text" class="form-control" id="current_scheduled_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="new_scheduled_date" class="form-label">New Scheduled Date</label>
                        <input type="text" class="form-control" id="new_scheduled_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="decision" class="form-label">Decision</label>
                        <select class="form-select" id="decision" name="decision">
                            <option value="" disabled selected>Select Decision</option>
                            <option value="approve">Approve</option>
                            <option value="deny">Deny</option>
                        </select>
                    </div>
                    <div class="mb-3" id="reasonContainer" style="display: none;">
                        <label for="reason" class="form-label">Reason for Denial</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
        function populateModal(request) {
    document.getElementById('request_id').value = request.id;
    document.getElementById('student_name').value = request.schedule.student.first_name + ' ' + request.schedule.student.last_name;
    document.getElementById('schedule_id').value = request.schedule_id;
    document.getElementById('current_scheduled_date').value = request.schedule.scheduled_date;
    document.getElementById('new_scheduled_date').value = request.new_scheduled_date;
    document.getElementById('status').value = request.status;

    // Set the form action dynamically
    document.getElementById('processForm').action = "{{ route('process.adjustment') }}";

    // Reset the decision and reason fields
    document.getElementById('decision').selectedIndex = 0;
    document.getElementById('reasonContainer').style.display = 'none';
    document.getElementById('reason').value = '';

    // Show/hide the reason input based on decision selection
    document.getElementById('decision').onchange = function () {
        if (this.value === 'deny') {
            document.getElementById('reasonContainer').style.display = 'block';
        } else {
            document.getElementById('reasonContainer').style.display = 'none';
        }
    };
}

    </script>

</body>

</html>

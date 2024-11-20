<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff Management</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="{{ route('owner.branch_analytics_view') }}" class="brand-link">
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
                            <a href="{{ route('owner.branch_analytics_view') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branch_management') }}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Branch Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff_management') }}" class="nav-link active">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Staff Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('course_management') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Course Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('package_management') }}" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>Package Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inquiries_requests') }}" class="nav-link">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Inquiries & Requests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('owner-reports') }}" class="nav-link">
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
                            <h1 class="m-0">Staff Management</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->

            <section class="class-overview m-4">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-primary rounded" title="Add Staff" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                        <i class="fas fa-plus mr-1"></i> Add Staff
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Branch</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffMembers as $staff)
                                <tr>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->phone_number }}</td>
                                    <td>{{ $staff->branch ? $staff->branch->name : 'No Branch Assigned' }}</td>
                                    <td>{{ $staff->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $staff->status}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn"
                                                data-id="{{ $staff->id }}"
                                                data-name="{{ $staff->name }}"
                                                data-email="{{ $staff->email }}"
                                                data-phone="{{ $staff->phone_number }}"
                                                data-status="{{ $staff->status }}">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleAddPassword">
                                <i class="fas fa-eye" id="toggleAddIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select class="form-control" id="branch_id" name="branch_id" required>
                            <option value="" disabled selected>Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <input type="hidden" name="role" value="staff">
                    <input type="hidden" name="status" value="active">
                    <button type="submit" class="btn btn-primary">Add Staff</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStaffForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_staff_id" name="staff_id">

                    <div class="form-group">
                        <label for="edit_staff_name">Name</label>
                        <input type="text" class="form-control" id="edit_staff_name" name="staff_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_staff_email">Email</label>
                        <input type="email" class="form-control" id="edit_staff_email" name="staff_email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_staff_phone">Phone Number</label>
                        <input type="text" class="form-control" id="edit_staff_phone" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_staff_password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_staff_password" name="password" placeholder="Leave blank if unchanged">
                            <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                <i class="fas fa-eye" id="toggleEditIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_staff_status">Status</label>
                        <select class="form-control" id="edit_staff_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/branch_analytics.js') }}"></script>

    <script>
        function togglePasswordVisibility(passwordFieldId, toggleIconId) {
            const passwordField = document.getElementById(passwordFieldId);
            const toggleIcon = document.getElementById(toggleIconId);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.getElementById('toggleAddPassword').addEventListener('click', function () {
            togglePasswordVisibility('password', 'toggleAddIcon');
        });

        document.getElementById('toggleEditPassword').addEventListener('click', function () {
            togglePasswordVisibility('edit_staff_password', 'toggleEditIcon');
        });
    </script>



    <!-- JavaScript to handle the edit button click -->

    <script>
        // Handle form submission with AJAX
        document.getElementById('addStaffForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Create FormData object

    // Make AJAX request
    fetch('/staff/store', { // Replace with your actual store route
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json()) // Parse the JSON response
    .then(data => {
        if (data.success) {
            // Show success alert
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); // Reload the page or refresh the table
            });
        } else {
            // Show error alert with validation messages
            Swal.fire({
                title: 'Error!',
                text: data.message || 'There was an issue adding the staff.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        error.json().then(errData => {
            let errorMessage = '';
            if (errData.errors) {
                errorMessage = Object.values(errData.errors).map(errorArray => errorArray[0]).join('\n');
            } else {
                errorMessage = 'There was an issue processing your request.';
            }

            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});


document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Get the staff data from the data attributes
        const staffId = this.getAttribute('data-id');
        const staffName = this.getAttribute('data-name');
        const staffEmail = this.getAttribute('data-email');
        const staffPhone = this.getAttribute('data-phone');
        const staffStatus = this.getAttribute('data-status');

        // Populate the form fields with the selected staff data
        document.getElementById('edit_staff_id').value = staffId;
        document.getElementById('edit_staff_name').value = staffName;
        document.getElementById('edit_staff_email').value = staffEmail;
        document.getElementById('edit_staff_phone').value = staffPhone;
        document.getElementById('edit_staff_status').value = staffStatus;

        // Show the modal
        var editStaffModal = new bootstrap.Modal(document.getElementById('editStaffModal'));
        editStaffModal.show();
    });
});

document.getElementById('editStaffForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Create FormData object

    const staffId = document.getElementById('edit_staff_id').value;

    // Make AJAX request to update the staff member
    fetch(`/staff/${staffId}`, { // Replace with your actual update route
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload(); // Reload the page to reflect changes
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message || 'There was an issue updating the staff.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'There was an issue processing your request.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});



    </script>



</body>

</html>

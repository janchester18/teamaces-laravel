<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Package Management</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
            <img class="animation__shake" src="{{ asset('images/admin/aceslogo.png') }}" alt="AdminLTE Logo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
            <a href="{{ route('owner.branch_analytics_view') }}" class="brand-link">
                <img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">TeamAces</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- User Panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        <small>{{ ucfirst(strtolower(Auth::user()->role)) }} - {{ Auth::user()->branch ? Auth::user()->branch->name : 'No Branch Assigned' }}</small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                            <a href="{{ route('staff_management') }}" class="nav-link">
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
                            <a href="{{ route('package_management') }}" class="nav-link active">
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
                            <h1 class="m-0">Package Management</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="package-overview m-4">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-primary rounded" title="Add Package" data-bs-toggle="modal" data-bs-target="#addPackageModal">
                        <i class="fas fa-plus mr-1"></i> Add Package
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Is Active</th>
                                <th>Courses Included</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                            <tr>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->price }}</td>
                                <td>{{ $package->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    @foreach($package->courses as $course)
                                        <span class="badge bg-secondary">{{ $course->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $package->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $package->id }}"
                                    data-name="{{ $package->name }}"
                                    data-price="{{ $package->price }}"
                                    data-is_active="{{ $package->is_active }}"
                                    data-courses="{{ json_encode($package->courses->pluck('id')) }}"
                                    data-bs-toggle="modal" data-bs-target="#editPackageModal">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

       <!-- Add Package Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPackageModalLabel">Add New Package</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPackageForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Courses Included</label>
                        <div class="form-check">
                            @foreach($courses as $course)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course-{{ $course->id }}">
                                    <label class="form-check-label" for="course-{{ $course->id }}">
                                        {{ $course->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Select multiple courses as needed.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Package</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Package Modal -->
<div class="modal fade" id="editPackageModal" tabindex="-1" role="dialog" aria-labelledby="editPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPackageModalLabel">Edit Package</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPackageForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_package_id" name="package_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_is_active" class="form-label">Is Active</label>
                        <select class="form-control" id="edit_is_active" name="is_active" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Courses Included</label>
                        <div class="form-check">
                            @foreach($courses as $course)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}" id="edit_course-{{ $course->id }}">
                                <label class="form-check-label" for="edit_course-{{ $course->id }}">
                                    {{ $course->name }}
                                </label>
                            </div>
                        @endforeach
                        </div>
                        <small class="text-muted">Select multiple courses as needed.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Package</button>
                </form>
            </div>
        </div>
    </div>
</div>



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
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/branch_analytics.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
// Handle form submission for adding a package
document.getElementById('addPackageForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Check if at least one course is selected
    const checkboxes = document.querySelectorAll('input[name="courses[]"]:checked');
    if (checkboxes.length < 2) {
        Swal.fire({
            title: 'Error!',
            text: 'Please select at least two courses.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Exit the function if no checkbox is checked
    }

    const formData = new FormData(this); // Create FormData object

    // Make AJAX request
    fetch('{{ route("package.store") }}', {
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
                text: data.message || 'There was an issue adding the package.',
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

// Populate edit modal with selected package data
// Populate edit modal with selected package data
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const packageId = this.getAttribute('data-id');
        const packageName = this.getAttribute('data-name');
        const packagePrice = this.getAttribute('data-price');
        const packageIsActive = this.getAttribute('data-is_active');
        const courseIds = JSON.parse(this.getAttribute('data-courses')); // Get the courses from data attribute

        // Set values in the edit modal
        document.getElementById('edit_package_id').value = packageId;
        document.getElementById('edit_name').value = packageName;
        document.getElementById('edit_price').value = packagePrice;
        document.getElementById('edit_is_active').value = packageIsActive;

        // Uncheck all checkboxes first
        @foreach($courses as $course)
            document.getElementById('edit_course-{{ $course->id }}').checked = false; // Uncheck all checkboxes first
        @endforeach

        // Check the corresponding courses
        courseIds.forEach(courseId => {
            const courseCheckbox = document.getElementById('edit_course-' + courseId);
            if (courseCheckbox) {
                courseCheckbox.checked = true; // Check the checkbox if it's part of the package
            }
        });
    });
});


// Handle form submission for editing a package
document.getElementById('editPackageForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Check if at least one course is selected
    const checkboxes = document.querySelectorAll('input[name="courses[]"]:checked');
    if (checkboxes.length < 2) {
        Swal.fire({
            title: 'Error!',
            text: 'Please select at least two courses.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return; // Exit the function if no checkbox is checked
    }

    const formData = new FormData(this); // Create FormData object

    // Make AJAX request
    fetch(`/packages/${document.getElementById('edit_package_id').value}`, {
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
                text: data.message || 'There was an issue updating the package.',
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

    </script>


</body>

</html>

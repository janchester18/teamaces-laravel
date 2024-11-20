<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Management</title>
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
                            <a href="{{ route('course_management') }}" class="nav-link active">
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
                            <h1 class="m-0">Course Management</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="class-overview m-4">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-primary rounded" title="Add Course" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                        <i class="fas fa-plus mr-1"></i> Add Course
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Acronym</th>
                                <th>Description</th>
                                <th>Number of Sessions</th>
                                <th>Hours per Session</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th style="min-width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->acronym }}</td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->number_of_sessions }}</td>
                                <td>{{ $course->hours_per_session }}</td>
                                <td>{{ $course->price }}</td>
                                <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn"
                                        data-id="{{ $course->id }}"
                                        data-name="{{ $course->name }}"
                                        data-acronym="{{ $course->acronym }}"
                                        data-description="{{ $course->description }}"
                                        data-number_of_sessions="{{ $course->number_of_sessions }}"
                                        data-hours_per_session="{{ $course->hours_per_session }}"
                                        data-price="{{ $course->price }}"
                                        data-bs-toggle="modal" data-bs-target="#editCourseModal">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="acronym" class="form-label">Acronym</label>
                        <input type="text" class="form-control" id="acronym" name="acronym" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="number_of_sessions" class="form-label">Number of Sessions</label>
                        <input type="number" class="form-control" id="number_of_sessions" name="number_of_sessions" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="hours_per_session" class="form-label">Hours per Session</label>
                        <input type="number" class="form-control" id="hours_per_session" name="hours_per_session" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Ensure to specify the PUT method for updating -->
                    <input type="hidden" id="edit_course_id" name="id"> <!-- Hidden field for course ID -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_acronym" class="form-label">Acronym</label>
                        <input type="text" class="form-control" id="edit_acronym" name="acronym" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_number_of_sessions" class="form-label">Number of Sessions</label>
                        <input type="number" class="form-control" id="edit_number_of_sessions" name="number_of_sessions" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_hours_per_session" class="form-label">Hours per Session</label>
                        <input type="number" class="form-control" id="edit_hours_per_session" name="hours_per_session" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="price" min="0" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Course</button>
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
        // Handle form submission with AJAX
        document.getElementById('addCourseForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Create FormData object

            // Make AJAX request
            fetch('/course/store', { // Replace with your actual store route
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Handle response errors
                    return response.json().then(errData => {
                        throw errData; // Throw the error data for the catch block
                    });
                }
                return response.json(); // Parse the JSON response
            })
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
                        text: data.message || 'There was an issue adding the course.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(errData => {
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

    // Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Prefill the edit modal with course data when an edit button is clicked
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Get data attributes from the clicked button
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const acronym = this.getAttribute('data-acronym');
        const description = this.getAttribute('data-description');
        const number_of_sessions = this.getAttribute('data-number_of_sessions');
        const hours_per_session = this.getAttribute('data-hours_per_session');
        const price = this.getAttribute('data-price');

        // Set the values in the edit form
        document.getElementById('edit_course_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_acronym').value = acronym;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_number_of_sessions').value = number_of_sessions;
        document.getElementById('edit_hours_per_session').value = hours_per_session;
        document.getElementById('edit_price').value = price;
    });
});

// Handle Edit Course Form Submission with AJAX
document.getElementById('editCourseForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Create FormData object
    const courseId = document.getElementById('edit_course_id').value; // Get course ID

    // Make AJAX request
    fetch(`/course/update/${courseId}`, {
        method: 'POST', // Ensure you're using the correct method
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken // Use the CSRF token from the meta tag
        }
    })
    .then(response => {
        if (!response.ok) {
            // Handle response errors
            return response.json().then(errData => {
                throw errData; // Throw the error data for the catch block
            });
        }
        return response.json(); // Parse the JSON response
    })
    .then(data => {
        // Handle success response
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
                text: data.message || 'There was an issue updating the course.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(errData => {
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


    </script>


</body>

</html>

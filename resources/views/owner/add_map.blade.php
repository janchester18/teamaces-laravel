<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Branch</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        #map { height: 400px; } /* Set the height of the map */
    </style>
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
                            <a href="{{ route('branch_management') }}" class="nav-link active">
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
                            <h1 class="m-0">Add New Branch</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row mx-4">
            <div class="col-md-6">
                <form id="branchForm" action="{{ route('branch.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="branch_name">Branch Name:</label>
                        <input type="text" id="branch_name" name="branch_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude:</label>
                        <input type="text" id="longitude" name="longitude" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
            <div class="col-md-6">
                <h5><strong>Select New Location</strong></h5>
                <div id="map" style="height: 400px;"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/branch_analytics.js') }}"></script>
    <script>
        src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" >
    </script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    // Initialize the map
    var map = L.map('map').setView([13.41, 122.56], 6); // Set the view to the Philippines

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add a click event to the map
    map.on('click', function(e) {
        // Get the latitude and longitude from the click event
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Populate the form fields
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

 // Handle form submission with confirmation and SweetAlert
document.getElementById('branchForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Ask for confirmation before submitting the form
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to add this branch?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, add it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, proceed with the AJAX submission
            var formData = new FormData(this);

            // Use Fetch API to submit the form data
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                }
            })
            .then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
})
.then(data => {
    console.log(data); // Log the data for debugging
    if (data.success) {
        Swal.fire({
            title: 'Success!',
            text: 'Branch added successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = "{{ route('branch_management') }}"; // Adjust the route name if needed
        });
    } else {
        Swal.fire({
            title: 'Error!',
            text: data.message || 'Failed to add branch. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
})

        }
    });
});


</script>



</body>

</html>

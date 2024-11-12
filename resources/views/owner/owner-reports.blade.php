<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports and Analytics</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
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
                            <a href="{{ route('owner-reports') }}" class="nav-link  active">
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


            <!-- Main content -->
            <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Reports & Analytics</h1>
                        </div>
                    </div>
                </div>
            </div>
<!-- /.content-header -->
<div class="mx-3">
    <div class="row">
        <!-- Card for Student -->
        <div class="col-md-6"> <!-- Adjust column width for 2x2 grid -->
            <div class="card mb-4"> <!-- Add margin bottom for spacing -->
                <div class="card-header">
                    Students Age Demographics
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- Chart -->
                    <div class="flex-grow-1 mb-3"> <!-- Margin bottom for mobile view -->
                        <canvas id="demographicsChart"></canvas>
                    </div>
                    <!-- Insights Button -->
                    <div class="text-center">
                        <button id="generateInsights" class="btn btn-primary rounded">Generate Insight</button>
                    </div>
                    <!-- Loader -->
                    <div id="loader" class="text-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- Insights Display -->
                    <div id="insights" class=""></div>
                </div>
            </div>
        </div>

        <!-- Card for Popular Courses -->
        <div class="col-md-6"> <!-- Adjust column width for 2x2 grid -->
            <div class="card mb-4"> <!-- Add margin bottom for spacing -->
                <div class="card-header">
                    Popular Courses
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- Chart -->
                    <div class="flex-grow-1 mb-3"> <!-- Margin bottom for mobile view -->
                        <canvas id="popularCoursesChart" style="max-height: 325px;"></canvas>
                    </div>
                    <!-- Insights Button -->
                    <div class="text-center">
                        <button id="generateCourseInsights" class="btn btn-primary rounded">Generate Insight</button>
                    </div>
                    <!-- Loader -->
                    <div id="courseLoader" class="text-center" style="display: none;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- Insights Display -->
                    <div id="courseInsights" class=""></div>
                </div>
            </div>
        </div>

        <!-- Add two more cards as needed -->
    </div>
</div>

<section class="class-overview mx-4 mt-0">
    <!-- Header Section (Visible Only on Print) -->
    <div class="print-header text-center mb-4" style="display: none;">
        <img src="path/to/logo.png" alt="Driving School Logo" class="logo" />
        <h1 class="school-name">TeamAces Driving Academy</h1>
    </div>

    <h3>Transactions</h3>

    <div class="table-responsive mt-0">
        <p><strong>Table Actions:</strong></p>
        <table class="table table-striped table-bordered" id="transactionsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course/Package</th>
                    <th>Price</th>
                    <th>Branch</th>
                    <th>Processed by</th>
                    <th>Date</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody id="classOverviewBody">
                <!-- TDC schedules will be injected here -->
            </tbody>
        </table>
    </div>
</section>

{{-- <!-- Print-Specific Styles -->
<style>
    @media print {
        body {
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }
        .print-header {
            display: block; /* Show header only when printing */
            margin-bottom: 20px; /* Space below the header */
        }
        .logo {
            max-width: 150px; /* Limit the logo size */
            height: auto; /* Keep aspect ratio */
        }
        .school-name {
            font-size: 20pt; /* Adjust font size */
            margin: 0; /* Remove margin */
        }
        .class-overview {
            width: 100%; /* Ensure full width */
            overflow: hidden; /* Prevent overflow */
        }
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders for a clean look */
        }
        th, td {
            padding: 8px; /* Adjust padding for readability */
            font-size: 12pt; /* Set font size for print */
            text-align: left; /* Align text left */
        }
        th {
            background-color: #f2f2f2; /* Light background for headers */
            border: 1px solid #ddd; /* Add border for headers */
        }
        td {
            border: 1px solid #ddd; /* Add border for cells */
        }
        @page {
            size: A4; /* Set page size to A4 */
            margin: 20mm; /* Set margins for A4 */
        }
    }
</style> --}}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<!-- Additional Buttons Dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <!-- STUDENT AGE DEMOGRAPHIC AND COURSE DISTRIBUTION -->
<script>
    // Initialize the demographics chart
    const demographicsCtx = document.getElementById('demographicsChart').getContext('2d');
    const ageGroups = @json($ageGroups);

    const demographicsLabels = Object.keys(ageGroups);
    const demographicsData = Object.values(ageGroups);

    const demographicsChart = new Chart(demographicsCtx, {
        type: 'bar', // or 'pie'
        data: {
            labels: demographicsLabels,
            datasets: [{
                label: 'Number of Students',
                data: demographicsData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('generateInsights').addEventListener('click', function() {
        // Show the loader
        const loader = document.getElementById('loader');
        loader.style.display = 'block'; // Show the loader
        document.getElementById('generateInsights').style.display = 'none'; // Hide the button
        document.getElementById('insights').innerText = ''; // Clear any previous insights

        // Call an endpoint to generate insights based on the demographics data
        fetch('/api/owner-generate-insights', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ demographics: ageGroups })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('insights').innerText = data.insights; // Show insights
        })
        .catch(error => {
            console.error('Error generating insights:', error);
            document.getElementById('insights').innerText = 'Error generating insights.'; // Show error message
        })
        .finally(() => {
            // Hide the loader and show the button again
            loader.style.display = 'none'; // Hide the loader
        });
    });

    // Initialize the popular courses chart
    const coursesCtx = document.getElementById('popularCoursesChart').getContext('2d');
    const popularCourses = @json($popularCourses); // Assuming you pass this data from the controller

    // Extracting labels and data correctly
    const courseLabels = popularCourses.map(course => course.course_name); // Adjust to fetch actual course names if needed
    const courseData = popularCourses.map(course => course.total);

    const popularCoursesChart = new Chart(coursesCtx, {
        type: 'pie', // or 'pie'
        data: {
            labels: courseLabels,
            datasets: [{
                label: 'Number of Enrollments',
                data: courseData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('generateCourseInsights').addEventListener('click', function() {
    // Show the loader
    const loader = document.getElementById('courseLoader');
    loader.style.display = 'block'; // Show the loader
    document.getElementById('generateCourseInsights').style.display = 'none'; // Hide the button
    document.getElementById('courseInsights').innerText = ''; // Clear any previous insights

    // Prepare the popular courses data
    const popularCoursesData = popularCourses.map(course => ({
        course_name: course.course_name,
        total: course.total
    }));

    // Call an endpoint to generate insights based on the popular courses data
    fetch('/api/owner-generate-course-insights', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ popularCourses: popularCoursesData }) // Pass the data for insights generation
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('courseInsights').innerText = data.insights; // Show insights
    })
    .catch(error => {
        console.error('Error generating insights:', error);
        document.getElementById('courseInsights').innerText = 'Error generating insights.'; // Show error message
    })
    .finally(() => {
        // Hide the loader and show the button again
        loader.style.display = 'none'; // Hide the loader
    });
});

</script>

<!-- Include this script at the bottom of your HTML file -->
<script>
    $(document).ready(function() {
        // Fetch the transactions when the page loads (without filtering by date initially)
        fetchBranchTransactions();

        // Event listener for the date range picker
        $('#scheduleDateRangePicker').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD' // Set the date format
            },
            autoUpdateInput: false // Prevent automatic date update on input
        }, function(start, end) {
            // Fetch transactions when the date range is selected
            fetchBranchTransactions(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            // Set the input value to show selected date range
            $('#scheduleDateRangePicker').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        });

        // Reset the date filter
        $('#resetSchedules').on('click', function() {
            $('#scheduleDateRangePicker').val(''); // Clear the date picker
            fetchBranchTransactions(); // Fetch all transactions
        });

        // Search by student name
        $('#searchStudent').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            filterTable(value);
        });



        // Function to filter the table based on student name
        function filterTable(value) {
            $('#classOverviewBody tr').filter(function() {
                $(this).toggle($(this).find('td:eq(1)').text().toLowerCase().indexOf(value) > -1);
            });
        }
    });
</script>

<!-- JavaScript Function to Print the Table -->
<script>
    function printTable() {
        var printContents = document.getElementById("transactionsTable").outerHTML;
        var headerContents = document.querySelector(".print-header").outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = headerContents + printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Reloads the page to restore the original contents
    }
    </script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with customized options for the owner side
        $('#transactionsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"],
            dom: 'Bfrtip', // 'B' enables the Buttons at the top
            "ajax": {
                "url": "{{ route('owner-transactions.branch') }}",
                "data": function(d) {
                    // Pass date range filters as additional parameters
                    d.start_date = $('#startDate').val();
                    d.end_date = $('#endDate').val();
                },
                "dataSrc": "" // Specify data source for response array
            },
            "columns": [
                { "data": "student_id" },
                { "data": "student_name" },
                { "data": "course_package" },
                { "data": "price" },
                { "data": "branch_name" }, // New branch column
                { "data": "processed_by" },
                { "data": "created_at" },
                { "data": "balance", "render": function(data) {
                    return `<span style="color: ${data == 0.00 ? 'green' : 'red'}">${data}</span>`;
                }},
            ]
        }).buttons().container().appendTo('#ownerTransactionsTable_wrapper .col-md-6:eq(0)');

        // Reload data on date range change
        $('#startDate, #endDate').change(function() {
            $('#transactionsTable').DataTable().ajax.reload();
        });
    });
</script>


</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
                            <a href="{{ route('admin.branch_analytics_view') }}" class="nav-link active">
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
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Analytics Overview Section -->
<div class="row">
    <!-- Total Students Card -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalStudents }}</h3>
                <p>Total Students</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Scheduled Sessions Today Card -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $scheduledSessionsToday }}</h3>
                <p>Scheduled Sessions Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>
                    <span class="d-none d-md-inline">
                        ₱{{ number_format($totalRevenue, 2) }}
                    </span>
                    <span class="d-md-none">
                        @if ($totalRevenue < 1000)
                            ₱{{ number_format($totalRevenue, 2) }}
                        @elseif ($totalRevenue < 1000000)
                            ₱{{ round($totalRevenue / 1000) }}k
                        @else
                            ₱{{ round($totalRevenue / 1000000, 1) }}M
                        @endif
                    </span>
                </h3>
                <p>Revenue</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <!-- New Enrollments Card -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $newEnrollments }}</h3>
                <p>New Students' Enrollments</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </div>

    <!-- Existing Students' Enrollments Card -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $existingStudentsEnrollments }}</h3>
                <p>Existing Students' Enrollments</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
</div>


                    <!-- Revenue Chart Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Revenue per Month</h3>
                                </div>
                                <div class="card-body d-flex flex-column flex-md-row">
                                    <!-- Chart Section -->
                                    <div class="flex-grow-1 mb-3 mb-md-0"> <!-- Margin bottom for mobile view -->
                                        <div class="form-group d-flex align-items-center">
                                            <label for="yearFilter" class="mr-3 mb-0">Select Year:</label>
                                            <select id="yearFilter" class="form-control w-auto"> <!-- w-auto for smaller size -->
                                                @foreach(range(Carbon\Carbon::now()->year, 2000) as $year)
                                                    <option value="{{ $year }}" {{ $year == $yearFilter ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <canvas id="revenueChart"></canvas>
                                    </div>
                                    <!-- Insights for Revenue -->
                                    <div class="insights-container ms-md-3" style="min-width: 300px;">
                                        <h4>LLM Generated Insights</h4>
                                        <div class="text-center">
                                            <button id="fetch-insights-button" class="btn btn-primary rounded">Get Insights</button>
                                        </div>
                                        <div id="loader" class="text-center" style="display: none;">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        <p id="insights-placeholder"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/branch_analytics.js') }}"></script>
    <script>
        src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" >
    </script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearFilter = document.getElementById('yearFilter');

        yearFilter.addEventListener('change', function() {
            const selectedYear = yearFilter.value;
            const url = new URL(window.location.href);
            url.searchParams.set('year', selectedYear);
            window.location.href = url.toString();
        });
            const controller = new AbortController(); // Create an instance of AbortController
            const signal = controller.signal; // Get the signal from the controller

            // Fetch insights function
            const fetchInsights = async () => {
                const selectedYear = yearFilter.value; // Get the selected year value
    // Show the loader and hide the button
    document.getElementById('loader').style.display = 'block'; // Show loader
    document.getElementById('fetch-insights-button').style.display = 'none'; // Hide the button
    document.getElementById('insights-placeholder').innerText = ''; // Clear insights placeholder



    try {
        const response = await fetch('{{ route('revenue_insights') }}?year=' + selectedYear, { signal });
        const data = await response.json();
        document.getElementById('insights-placeholder').innerText = data.insights; // Show insights
    } catch (error) {
        if (error.name === 'AbortError') {
            console.log('Fetch aborted');
        } else {
            console.error('Error fetching insights:', error);
            document.getElementById('insights-placeholder').innerText = 'Error fetching insights.';
        }
    } finally {
        // Hide the loader and show the button again
        document.getElementById('loader').style.display = 'none'; // Hide loader
        document.getElementById('fetch-insights-button').style.display = 'none'; // Show the button again
    }
};


            // Line chart (Revenue)
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueData = @json($revenueData); // Pass the revenue data from PHP to JavaScript

            const labels = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const revenueChartConfig = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: Object.values(revenueData),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            new Chart(revenueCtx, revenueChartConfig); // Create the revenue chart

            // Start fetching insights when the button is clicked
            document.getElementById('fetch-insights-button').addEventListener('click', fetchInsights);

            // Stop fetching insights when navigating away
            window.addEventListener('beforeunload', function() {
                controller.abort(); // Abort the fetch request when leaving the page
            });
        });
    </script>


</body>

</html>

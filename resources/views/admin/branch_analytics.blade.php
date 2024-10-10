<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Analytics</title>
    <!-- Font Awesome 6.4.0 CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.0 CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
                <h5>{{ Auth::user()->name }}</h5> <!-- Display User's Name -->
                <p class="mb-2">{{ Auth::user()->branch ? Auth::user()->branch->name : 'No Branch Assigned' }}</p> <!-- Display Branch Name -->
                <p>{{ ucfirst(strtolower(Auth::user()->role)) }}</p> <!-- Display Role in Sentence Case -->
            </div>

              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('admin.branch_analytics_view') }}"><i class="fas fa-home"></i> Dashboard</a>
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
                        @csrf <!-- CSRF token for security -->
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
                    <h2>Dashboard</h2>
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

                <!-- Analytics Overview Section -->
                <section class="analytics-overview my-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-user-graduate"></i> Total Students</h3>
                                <p>{{ $totalStudents }}</p> <!-- Display the count of total students -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-chalkboard-teacher"></i> Scheduled Sessions Today</h3>
                                <p>{{ $scheduledSessionsToday }}</p> <!-- Display the count of scheduled sessions for today -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-dollar-sign"></i> Revenue</h3>
                                <p>₱{{ number_format($totalRevenue, 2) }}</p> <!-- Display the total revenue formatted as currency -->
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Pending Requests Section -->
                <section class="pending-requests my-4">
                    <h3>Pending Requests</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h4><i class="fas fa-user-plus"></i> Enrollment</h4>
                                <p>10</p> <!-- Example value for pending enrollments -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h4><i class="fas fa-box-open"></i> Package</h4>
                                <p>5</p> <!-- Example value for pending packages -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h4><i class="fas fa-calendar-alt"></i> Schedule Adjustment</h4>
                                <p>3</p> <!-- Example value for pending schedule adjustments -->
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Revenue Chart Section -->
                <section class="revenue-chart my-4">
                    <h3>Revenue per Month</h3>
                    <div class="card p-3">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </section>

                <!-- Insights Section -->
                <section class="insights my-4">
                    <h3>AI Generated Insights</h3>
                    <div class="card p-3">
                        <p id="insights-placeholder">Loading insights...</p>
                    </div>
                </section>


            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('revenue_insights') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('insights-placeholder').innerText = data.insights;
            })
            .catch(error => {
                console.error('Error fetching insights:', error);
                document.getElementById('insights-placeholder').innerText = 'Error fetching insights.';
            });
    });


        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueData = @json($revenueData); // Pass the revenue data from PHP to JavaScript

            const labels = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: Object.values(revenueData), // Use the revenue data for the line chart
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.1
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const revenueChart = new Chart(ctx, config);
        });
    </script>
</body>
</html>

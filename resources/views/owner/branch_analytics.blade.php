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
                <p class="mb-2">{{ Auth::user()->branch ? Auth::user()->branch->name : '' }}</p> <!-- Display Branch Name -->
                <p>{{ ucfirst(strtolower(Auth::user()->role)) }}</p> <!-- Display Role in Sentence Case -->
            </div>

              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('branch_analytics') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('class_scheduling') }}"><i class="fas fa-calendar-check"></i> Class Scheduling</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('student_management') }}"><i class="fas fa-user-graduate"></i> Student Management</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('staff_management') }}"><i class="fas fa-users"></i> Staff Management</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="{{ route('branch_management') }}"><i class="fas fa-building"></i> Branch Management</a>
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
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <header class="d-flex justify-content-between align-items-center py-3">
                    <h2>Branch Analytics</h2>
                    <div class="profile">
                        <a href="#" class="text-dark"><i class="fas fa-user-circle"></i> Profile</a>
                    </div>
                </header>

                <!-- Analytics Overview Section -->
                <section class="analytics-overview my-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-user-graduate"></i> Students</h3>
                                <p>500</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-chalkboard-teacher"></i> Instructors</h3>
                                <p>25</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-dollar-sign"></i> Revenue</h3>
                                <p>$120,000</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Revenue Chart Section -->
                <section class="revenue-chart my-4">
                    <h3>Revenue by Branch</h3>
                    <div class="card p-3">
                        <p>Revenue Chart Placeholder</p>
                        <!-- Insert your chart library here (e.g., Chart.js, Google Charts) -->
                    </div>
                </section>

                <!-- Branch Performance Table Section -->
                <section class="branch-performance my-4">
                    <h3>Branch Performance</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Branch Name</th>
                                    <th>Students</th>
                                    <th>Instructors</th>
                                    <th>Revenue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Main Branch</td>
                                    <td>300</td>
                                    <td>15</td>
                                    <td>$80,000</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>North Branch</td>
                                    <td>150</td>
                                    <td>7</td>
                                    <td>$30,000</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>East Branch</td>
                                    <td>50</td>
                                    <td>3</td>
                                    <td>$10,000</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">View</button>
                                    </td>
                                </tr>
                                <!-- Repeat rows as necessary -->
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

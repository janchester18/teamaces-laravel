<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
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
                <div class="logo-container text-center py-4">
                    <img src="images/admin/aceslogo.png" alt="Logo" class="sidebar-logo">
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
                    <a class="nav-link text-light logout-btn" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                  </li>
                </ul>
              </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <!-- Top Nav -->
                <header class="d-flex justify-content-between align-items-center py-3">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <div class="notifications">
                        <a href="#" class="text-dark"><i class="fas fa-bell"></i> Notifications</a>
                    </div>
                    <div class="profile">
                        <a href="#" class="text-dark"><i class="fas fa-user-circle"></i> Profile</a>
                    </div>
                </header>

                <!-- Staff Management Dashboard -->
                <section class="dashboard my-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-user-tie"></i> Total Staff</h3>
                                <p>15</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-user-clock"></i> On Leave</h3>
                                <p>3</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-3 text-center">
                                <h3><i class="fas fa-check-circle"></i> Available</h3>
                                <p>12</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Staff Assignment Section -->
                <section class="staff-assignments my-4">
                    <h3>Staff Assignments</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Staff Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>Instructor</td>
                                    <td>Assigned</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Reassign</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>Admin</td>
                                    <td>Available</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Assign</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tom Clark</td>
                                    <td>Maintenance</td>
                                    <td>On Leave</td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary" disabled>Assign</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Staff Maintenance Section -->
                <section class="staff-maintenance my-4">
                    <h3>Staff Development</h3>
                    <div class="card p-3">
                        <p>Training and development schedules for staff members</p>
                        <!-- Add detailed training or development schedules here -->
                    </div>
                </section>

                <!-- Recent Activities -->
                <section class="recent-activities my-4">
                    <h3>Recent Activities</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Staff #2 completed training</li>
                        <li class="list-group-item">Instructor Jane assigned a new role</li>
                        <li class="list-group-item">Staff #3 is on leave for 2 weeks</li>
                    </ul>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

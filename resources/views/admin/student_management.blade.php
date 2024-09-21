<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
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
                <header class="d-flex justify-content-between align-items-center py-3">
                    <h2>Student Management</h2>
                    <div class="profile">
                        <a href="#" class="text-dark"><i class="fas fa-user-circle"></i> Profile</a>
                    </div>
                </header>

                <!-- Add Student Section -->
                <section class="add-student my-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Add New Student</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="studentName" class="form-label">Student Name</label>
                                    <input type="text" class="form-control" id="studentName" placeholder="Enter student name">
                                </div>
                                <div class="mb-3">
                                    <label for="studentEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="studentEmail" placeholder="Enter student email">
                                </div>
                                <div class="mb-3">
                                    <label for="studentPhone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="studentPhone" placeholder="Enter phone number">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Student</button>
                            </form>
                        </div>
                    </div>
                </section>

                <!-- Student List Section -->
                <section class="student-list my-4">
                    <h3>Student List</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john.doe@example.com</td>
                                    <td>(123) 456-7890</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
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

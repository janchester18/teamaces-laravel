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
                    <img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo" class="sidebar-logo">
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
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Pending Enrollments Table -->
                <section class="pending-enrollments my-4">
                    <h3>Pending Enrollments</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>Basic Driving Course</td>
                                    <td>Pending Payment</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="confirmPayment(1)">Confirm Payment</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>Advanced Driving Course</td>
                                    <td>Pending Payment</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="confirmPayment(2)">Confirm Payment</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Robert Brown</td>
                                    <td>Intermediate Driving Course</td>
                                    <td>Pending Payment</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="confirmPayment(3)">Confirm Payment</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Confirmation and Payment Logic -->
    <script>
        function confirmPayment(studentId) {
            let confirmAction = confirm("Are you sure you want to confirm this payment and add the student to the database?");
            if (confirmAction) {
                // Logic to move the student to the student database and remove from pending enrollments
                alert("Payment confirmed for student ID: " + studentId);
                // Here you would update the table or remove the entry
            } else {
                alert("Payment confirmation cancelled.");
            }
        }
    </script>
</body>
</html>

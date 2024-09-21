<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
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
                    <h2>Branch Management</h2>
                    <div class="profile">
                        <a href="#" class="text-dark"><i class="fas fa-user-circle"></i> Profile</a>
                    </div>
                </header>

                <!-- Add Branch Section -->
                <section class="add-branch my-4">
                    <h3>Add New Branch</h3>
                    <form>
                        <div class="mb-3">
                            <label for="branchName" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" id="branchName" placeholder="Enter branch name">
                        </div>
                        <div class="mb-3">
                            <label for="branchLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="branchLocation" placeholder="Enter branch location">
                        </div>
                        <div class="mb-3">
                            <label for="branchManager" class="form-label">Branch Manager</label>
                            <input type="text" class="form-control" id="branchManager" placeholder="Enter manager's name">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Branch</button>
                    </form>
                </section>

                <!-- Branch List Section -->
                <section class="branch-list my-4">
                    <h3>Branch List</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Branch Name</th>
                                    <th>Location</th>
                                    <th>Manager</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Main Branch</td>
                                    <td>123 Main St.</td>
                                    <td>Jane Smith</td>
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

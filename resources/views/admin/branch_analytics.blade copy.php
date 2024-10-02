<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-responsive.css') }}">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar for PC view -->
        <nav id="sidebar" class="bg-dark text-light">
            <div class="sidebar-header">
                <img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo" class="sidebar-logo">
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-calendar-check"></i> Class Scheduling</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user-graduate"></i> Student Management</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user-plus"></i> Pending Enrollments</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cogs"></i> Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar for mobile view -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="#"><img src="{{ asset('images/admin/aceslogo.png') }}" alt="Logo" height="30"></a>
                    <div class="ms-auto d-flex align-items-center">
                        <a href="#" class="me-3"><i class="fas fa-bell"></i></a>
                        <a href="#"><i class="fas fa-user-circle"></i></a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <h2 class="mb-4">Branch Analytics</h2>

                <!-- Analytics Overview Section -->
                <section class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3><i class="fas fa-user-graduate"></i> Students</h3>
                                <p class="card-text">123123</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3><i class="fas fa-chalkboard-teacher"></i> Instructors</h3>
                                <p class="card-text">123123</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3><i class="fas fa-dollar-sign"></i> Revenue</h3>
                                <p class="card-text">123123</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Revenue Chart Section -->
                <section class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Revenue by Branch</h3>
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Branch Performance Table Section -->
                <section class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Branch Performance</h3>
                                <div class="table-responsive">
                                    <table class="table table-striped">
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
                                                <td>asdf</td>
                                                <td>asdf</td>
                                                <td>asdf</td>
                                                <td>asdf</td>
                                                <td>asdf</td>
                                                <td>asdf</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

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
        <a class="nav-link active text-light" href="#"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="#"><i class="fas fa-cogs"></i> Settings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light logout-btn" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </nav>

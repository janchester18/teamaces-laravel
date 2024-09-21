<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Scheduling</title>
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
                    <!-- Removed Search Bar, Notifications, and Profile -->
                </header>

                <!-- Class Scheduling -->
                <section class="class-scheduling my-4">
                    <h2>Class Scheduling</h2>
                    <div class="calendar-container">
                        <div class="calendar-header d-flex justify-content-between align-items-center">
                            <button class="calendar-nav" id="prevMonth" aria-label="Previous month"><i class="fas fa-chevron-left"></i></button>
                            <div class="d-flex align-items-center">
                                <label for="monthSelect" class="visually-hidden">Select Month</label>
                                <select id="monthSelect" class="form-select me-2" aria-label="Select Month"></select>
                                <label for="yearSelect" class="visually-hidden">Select Year</label>
                                <select id="yearSelect" class="form-select" aria-label="Select Year"></select>
                            </div>
                            <button class="calendar-nav" id="nextMonth" aria-label="Next month"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div id="calendar" class="calendar"></div>
                    </div>

                    <!-- Overview of Created Classes -->
                    <section class="class-overview my-4">
                        <h4>Overview of Scheduled Classes</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Class Name</th>
                                        <th>Time</th>
                                        <th>Instructor</th>
                                    </tr>
                                </thead>
                                <tbody id="classOverviewBody">
                                    <!-- Classes will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
          const calendarContainer = document.getElementById('calendar');
          const monthSelect = document.getElementById('monthSelect');
          const yearSelect = document.getElementById('yearSelect');
          const classOverviewBody = document.getElementById('classOverviewBody');

          function getManilaDate() {
              // Create date object in UTC
              const utcDate = new Date();
              // Get Manila timezone offset (UTC+8)
              const manilaOffset = 8 * 60;
              // Calculate Manila time by adjusting for timezone difference
              const manilaDate = new Date(utcDate.getTime() + (manilaOffset - utcDate.getTimezoneOffset()) * 60 * 1000);
              console.log('Manila Date:', manilaDate.toString());
              return manilaDate;
          }

          const manilaDate = getManilaDate();
          let currentYear = manilaDate.getFullYear();
          let currentMonth = manilaDate.getMonth();
          let scheduledClasses = [];

          function generateCalendar(year, month) {
              calendarContainer.innerHTML = '';
              const firstDay = new Date(year, month, 1).getDay();
              const lastDate = new Date(year, month + 1, 0).getDate();

              // Update month and year selection
              monthSelect.value = month;
              yearSelect.value = year;

              // Create header for days of the week
              const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
              weekdays.forEach(day => {
                  const div = document.createElement('div');
                  div.textContent = day;
                  calendarContainer.appendChild(div);
              });

              // Create empty boxes for days before the start of the month
              for (let i = 0; i < firstDay; i++) {
                  const div = document.createElement('div');
                  calendarContainer.appendChild(div);
              }

              // Create calendar days
              for (let day = 1; day <= lastDate; day++) {
                  const div = document.createElement('div');
                  div.textContent = day;
                  div.addEventListener('click', () => openModal(year, month, day));
                  calendarContainer.appendChild(div);
              }

              // Highlight today
              const todayDiv = calendarContainer.querySelector(`div:nth-child(${manilaDate.getDate() + firstDay + 1})`);
              if (todayDiv) todayDiv.classList.add('today');
          }

          function openModal(year, month, day) {
              const classDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
              const modalHTML = `
                  <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="classModalLabel">Schedule Class on ${classDate}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <form id="classForm">
                                      <div class="mb-3">
                                          <label for="className" class="form-label">Class Name</label>
                                          <input type="text" class="form-control" id="className" required>
                                      </div>
                                      <div class="mb-3">
                                          <label for="classTime" class="form-label">Time</label>
                                          <input type="time" class="form-control" id="classTime" required>
                                      </div>
                                      <div class="mb-3">
                                          <label for="classInstructor" class="form-label">Instructor</label>
                                          <input type="text" class="form-control" id="classInstructor" required>
                                      </div>
                                      <button type="submit" class="btn btn-primary">Save Class</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              `;

              document.body.insertAdjacentHTML('beforeend', modalHTML);
              const modal = new bootstrap.Modal(document.getElementById('classModal'));
              modal.show();

              document.getElementById('classForm').addEventListener('submit', function (e) {
                  e.preventDefault();
                  const className = document.getElementById('className').value;
                  const classTime = document.getElementById('classTime').value;
                  const classInstructor = document.getElementById('classInstructor').value;

                  scheduledClasses.push({ date: classDate, name: className, time: classTime, instructor: classInstructor });
                  updateClassOverview();
                  modal.hide();
              });
          }

          function updateClassOverview() {
              classOverviewBody.innerHTML = '';
              scheduledClasses.forEach(scheduledClass => {
                  const tr = document.createElement('tr');
                  tr.innerHTML = `
                      <td>${scheduledClass.date}</td>
                      <td>${scheduledClass.name}</td>
                      <td>${scheduledClass.time}</td>
                      <td>${scheduledClass.instructor}</td>
                  `;
                  classOverviewBody.appendChild(tr);
              });
          }

          function populateMonthAndYearSelects() {
              const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
              months.forEach((month, index) => {
                  const option = document.createElement('option');
                  option.value = index;
                  option.textContent = month;
                  monthSelect.appendChild(option);
              });

              for (let year = 2020; year <= 2030; year++) {
                  const option = document.createElement('option');
                  option.value = year;
                  option.textContent = year;
                  yearSelect.appendChild(option);
              }
          }

          document.getElementById('prevMonth').addEventListener('click', function () {
              if (currentMonth === 0) {
                  currentMonth = 11;
                  currentYear--;
              } else {
                  currentMonth--;
              }
              generateCalendar(currentYear, currentMonth);
          });

          document.getElementById('nextMonth').addEventListener('click', function () {
              if (currentMonth === 11) {
                  currentMonth = 0;
                  currentYear++;
              } else {
                  currentMonth++;
              }
              generateCalendar(currentYear, currentMonth);
          });

          monthSelect.addEventListener('change', function () {
              currentMonth = parseInt(this.value);
              generateCalendar(currentYear, currentMonth);
          });

          yearSelect.addEventListener('change', function () {
              currentYear = parseInt(this.value);
              generateCalendar(currentYear, currentMonth);
          });

          populateMonthAndYearSelects();
          generateCalendar(currentYear, currentMonth);
      });
  </script>

</body>

</html>

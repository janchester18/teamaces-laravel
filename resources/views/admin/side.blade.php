<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Sidebar styles */
        .sidebar {
            width: 220px;
            height: 100vh;
            background-color: #141820 !important;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 999;
            overflow-y: hidden;
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo {
            width: 60%;
            height: auto;
            margin: -30px auto;
            align-items: center;
        }

        .sidebar-logo img {
            width: 100%;
            height: auto;
            padding-top: 25px;
            padding-bottom: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            flex-grow: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            font-size: 13px; /* Font size for main buttons */
            padding: 15px 20px; /* Padding for main buttons */
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .nav-link:hover {
            background-color: #1b4b80;
        }

        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .sidebar-divider {
            border: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 10px 0;
        }

        /* Submenu styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        /* This class controls the opening of the submenu */
        .submenu.open {
            max-height: 200px; /* Adjust based on the number of submenu items */
        }

        /* Target submenu items specifically */
        .submenu .nav-link {
            font-size: 12px; /* Smaller font size for submenu items */
            padding: 10px 20px; /* Adjust padding to align with main menu */
            color: #ccc; /* Slightly different color for submenu items */
            padding-left: 40px; /* This nudges submenu items to the right */
        }

        .submenu .nav-link:hover {
            background-color: #1b4b80; /* Maintain hover effect for submenu items */
        }

        /* Main content area */
        .main-content {
            margin-left: 220px;
            padding: 20px;
            transition: margin-left 0.3s ease; /* Smooth transition for content shift */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                transition: none; /* Disable transition on mobile */
            }

            .sidebar.show {
                transform: translateX(0);
                z-index: 1000; /* Ensure sidebar overlaps */
            }

            .main-content.overlap {
                position: relative;
                z-index: 998; /* Behind sidebar when open */
            }
        }

        #sidebarToggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1001;
            background-color: #141820;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
            }
        }
    </style>
  </head>
  <body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="Images/aceslogo.png" alt="TeamAces Logo">
        </div>
        <ul>
            <li><hr class="sidebar-divider"></li>
            <li><a href="index.html" class="nav-link"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><hr class="sidebar-divider"></li>
            <li>
                <a class="nav-link" id="reportsAnalyticsToggle">
                    <i class="fas fa-chart-line"></i> Pending Enrollments
                    <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                </a>
                <ul class="submenu" id="reportsAnalyticsSubmenu">
                    <li><a href="charts.html" class="nav-link"><i class="fas fa-chart-pie"></i> New Enrollments</a></li>
                    <li><a href="transaction-tables.html" class="nav-link"><i class="fas fa-table"></i> Existing Students</a></li>
                    <li><a href="transaction-tables.html" class="nav-link"><i class="fas fa-table"></i> Package Approval</a></li>
                </ul>
            </li>
            <li><a href="class_scheduling.html" class="nav-link"><i class="fas fa-calendar-check"></i> Class Scheduling</a></li>
            <li><a href="student_management.html" class="nav-link"><i class="fas fa-user-graduate"></i> Student Management</a></li>
            <li><hr class="sidebar-divider"></li>
            <li>
                <a class="nav-link" id="reportsAnalyticsToggle">
                    <i class="fas fa-chart-line"></i> Reports & Analytics
                    <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                </a>
                <ul class="submenu" id="reportsAnalyticsSubmenu">
                    <li><a href="charts.html" class="nav-link"><i class="fas fa-chart-pie"></i> Charts</a></li>
                    <li><a href="transaction-tables.html" class="nav-link"><i class="fas fa-table"></i> Transaction Tables</a></li>
                </ul>
            </li>
            <li><hr class="sidebar-divider"></li>
            <li><a href="#" class="nav-link"><i class="fas fa-cogs"></i> Settings</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <button id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

  </body>
</head>

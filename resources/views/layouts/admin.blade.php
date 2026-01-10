<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Test - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->

    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <style>
        :root {
            --primary: #0d6efd;
            --secondary: #6c757d;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        /* Smooth Scrolling */
        * {
            scroll-behavior: smooth;
        }

        /*** Layout ***/
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
            background: #fff;
            transition: 0.3s;
            z-index: 999;
            border-right: 1px solid #dee2e6;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .sidebar-navbar {
            background: transparent !important;
        }

        .sidebar-navbar .navbar-brand h3 {
            font-weight: 600;
            color: var(--primary) !important;
        }

        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-height: 100vh;
            background: var(--light);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .content > nav {
            flex-shrink: 0;
        }

        .content > div:last-child {
            margin-top: auto;
        }

        /* Responsive Behavior */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.open {
                margin-left: 0;
            }

            .content {
                width: 100%;
                margin-left: 0;
            }

            .content.open {
                margin-left: 250px;
            }
        }

        /* Mobile Overlay */
        @media (max-width: 991.98px) {
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /*** Navbar ***/
        .sidebar .navbar .navbar-nav .nav-link {
            padding: 10px 20px;
            color: var(--dark);
            font-weight: 500;
            border-left: 3px solid transparent;
            border-radius: 0;
            outline: none;
            margin: 2px 0;
            transition: all 0.2s ease;
        }

        .sidebar .navbar .navbar-nav .nav-link:hover {
            background: #f8f9fa;
            border-left-color: var(--primary);
        }

        .sidebar .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
            background: #e7f1ff;
            border-left-color: var(--primary);
        }

        .sidebar .navbar .navbar-nav .nav-link i {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 6px;
            transition: .2s;
            color: var(--dark);
        }

        .sidebar .navbar .navbar-nav .nav-link:hover i,
        .sidebar .navbar .navbar-nav .nav-link.active i {
            background: var(--primary);
            color: white;
        }

        .navbar .nav-item .dropdown-menu {
            top: 100%;
            margin-top: 0;
            background: #FFFFFF;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sticky-top {
            top: 0;
            z-index: 999;
        }

        .content .navbar {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        .content .navbar .navbar-nav .nav-link {
            margin-left: 25px;
            padding: 12px 0;
            color: var(--dark);
            outline: none;
        }

        .content .navbar .navbar-nav .nav-link:hover,
        .content .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        .content .navbar .sidebar-toggler {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            transition: .2s;
        }

        .content .navbar .sidebar-toggler:hover {
            background: var(--light);
        }

        .content .navbar .sidebar-toggler i {
            font-size: 18px;
            color: var(--dark);
        }

        /* Responsive Navbar */
        @media (max-width: 575.98px) {
            .content .navbar .navbar-nav .nav-link {
                margin-left: 10px;
            }

            .content .navbar .dropdown-menu {
                position: absolute !important;
                right: 0 !important;
            }
        }

        /* Cards */
        .bg-light {
            background: #fff !important;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .bg-white {
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        /* Tables - Responsive */
        .table {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: var(--primary);
            color: white;
        }

        .table thead tr:first-child th {
            border-top: 1px solid var(--primary);
        }

        .table thead th {
            color: white !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        .table thead th:first-child {
            border-top-left-radius: 5px;
        }

        .table thead th:last-child {
            border-top-right-radius: 5px;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 5px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 5px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-bordered {
            border: 1px solid #dee2e6 !important;
        }

        .table-bordered thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.3) !important;
        }

        /* Fix for DataTables */
        table.dataTable {
            border: 1px solid #dee2e6 !important;
            border-collapse: separate !important;
        }

        table.dataTable thead th {
            border-top: 1px solid var(--primary) !important;
        }

        /* Mobile Table Responsiveness */
        @media (max-width: 767.98px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table thead {
                font-size: 0.875rem;
            }

            .table tbody {
                font-size: 0.875rem;
            }
        }

        /* Buttons */
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        /* Responsive Button Groups */
        @media (max-width: 575.98px) {
            .btn-group {
                display: flex;
                flex-direction: column;
            }

            .btn-group .btn {
                margin-left: 0 !important;
                margin-top: 5px;
            }

            .btn-group .btn:first-child {
                margin-top: 0;
            }
        }

        /* Alert */
        .alert {
            border-radius: 6px;
        }

        /* Form - Responsive */
        .form-control,
        .form-select {
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .form-floating > .form-control:focus ~ label {
            color: var(--primary);
        }

        /* Mobile Form Optimization */
        @media (max-width: 767.98px) {
            .form-floating {
                margin-bottom: 1rem;
            }

            .row.g-2 > * {
                padding-right: calc(var(--bs-gutter-x) * .5);
                padding-left: calc(var(--bs-gutter-x) * .5);
            }
        }

        /* Container Responsiveness */
        .container-xxl {
            max-width: 100% !important;
            width: 100% !important;
            padding-right: 1rem;
            padding-left: 1rem;
        }

        @media (max-width: 991.98px) {
            .container-xxl {
                padding-right: 1rem;
                padding-left: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .container-xxl {
                padding-right: 0.5rem;
                padding-left: 0.5rem;
            }

            .pt-2 {
                padding-top: 0.5rem !important;
            }

            .px-2 {
                padding-right: 0.5rem !important;
                padding-left: 0.5rem !important;
            }
        }

        /* DataTables Responsive */
        @media (max-width: 767.98px) {
            div.dataTables_wrapper div.dataTables_length,
            div.dataTables_wrapper div.dataTables_filter {
                text-align: left;
            }

            div.dataTables_wrapper div.dataTables_paginate {
                text-align: center;
            }
        }

        /* Stats Cards Mobile */
        @media (max-width: 767.98px) {
            .col-sm-6.col-xl-4 {
                margin-bottom: 1rem;
            }
        }

        /* Mobile Footer */
        @media (max-width: 767.98px) {
            .footer .row > div {
                text-align: center !important;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay" onclick="closeSidebar()"></div>
        
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar sidebar-navbar">
                <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>Test</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-dark">{{ Auth::user()->name }}</h6>
                        <span class="text-muted">Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    @if(Auth::user()->role === 'parent')
                        <a href="{{ route('parent.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}"><i class="fa fa-home me-2"></i>Parent Dashboard</a>
                        <a href="{{ route('mailbox.index') }}" class="nav-item nav-link {{ request()->routeIs('mailbox.*') ? 'active' : '' }}"><i class="fa fa-envelope me-2"></i>Mailbox</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    @endif
                    
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('master.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-cog me-2"></i>Master Module
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->routeIs('master.*') ? 'show' : '' }}">
                            <a href="{{ route('master.school-settings.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.school-settings.*') ? 'active' : '' }}">School Details</a>
                            <a href="{{ route('master.classes.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.classes.*') ? 'active' : '' }}">Classes</a>
                            <a href="{{ route('master.fee-structures.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.fee-structures.*') ? 'active' : '' }}">Fee Structure</a>
                            <a href="{{ route('master.courses.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.courses.*') ? 'active' : '' }}">Courses</a>
                            <a href="{{ route('master.academic-sessions.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.academic-sessions.*') ? 'active' : '' }}">Academic Sessions</a>
                            <a href="{{ route('timetable.index') }}" class="dropdown-item nav-link {{ request()->routeIs('timetable.*') ? 'active' : '' }}">Time Table / Routine</a>
                            <a href="{{ route('master.promotion.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.promotion.*') ? 'active' : '' }}">Promotion</a>
                            <hr class="dropdown-divider">
                            <a href="{{ route('student-attendance.index') }}" class="dropdown-item nav-link {{ request()->routeIs('student-attendance.index') ? 'active' : '' }}">Daily Attendance</a>
                            <a href="{{ route('student-attendance.report') }}" class="dropdown-item nav-link {{ request()->routeIs('student-attendance.report') ? 'active' : '' }}">Attendance Report</a>
                            <hr class="dropdown-divider">
                            <a href="{{ route('master.exams.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.exams.*') || (request()->routeIs('exams.*') && !request()->routeIs('exams.reports.*')) ? 'active' : '' }}">Exams & Marks</a>
                            <a href="{{ route('exams.reports.index') }}" class="dropdown-item nav-link {{ request()->routeIs('exams.reports.*') ? 'active' : '' }}">Exam Reports</a>
                            <a href="{{ route('master.notices.index') }}" class="dropdown-item nav-link {{ request()->routeIs('master.notices.*') ? 'active' : '' }}">Notice Board</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('fees.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-money-check-alt me-2"></i>Fees Management
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->routeIs('fees.*') ? 'show' : '' }}">
                            <a href="{{ route('fees.payments.create') }}" class="dropdown-item nav-link {{ request()->routeIs('fees.payments.create') ? 'active' : '' }}">Collect Fee</a>
                            <a href="{{ route('fees.payments.index') }}" class="dropdown-item nav-link {{ request()->routeIs('fees.payments.index') ? 'active' : '' }}">Payment History</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->is('staff*') || request()->is('attendance*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-users-cog me-2"></i>Staff Module
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->is('staff*') || request()->is('attendance*') ? 'show' : '' }}">
                            <a href="{{ route('staff.index') }}" class="dropdown-item nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}">Staff List</a>
                            <a href="{{ route('attendance.mark') }}" class="dropdown-item nav-link {{ request()->routeIs('attendance.mark') ? 'active' : '' }}">Face Attendance</a>
                            <a href="{{ route('attendance.index') }}" class="dropdown-item nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}">Attendance Log</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('library.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-book me-2"></i>Library Module
                        </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->routeIs('library.*') ? 'show' : '' }}">
                            <a href="{{ route('library.books.index') }}" class="dropdown-item nav-link {{ request()->routeIs('library.books.*') ? 'active' : '' }}">Book List</a>
                            <a href="{{ route('library.issues.index') }}" class="dropdown-item nav-link {{ request()->routeIs('library.issues.*') ? 'active' : '' }}">Issue / Return</a>
                        </div>
                    </div>

                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" class="nav-item nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fa fa-user me-2"></i>Users</a>
                        <a href="{{ route('students.index') }}" class="nav-item nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"><i class="fa fa-user-graduate me-2"></i>Students</a>
                        <a href="{{ route('certificates.index') }}" class="nav-item nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}"><i class="fa fa-certificate me-2"></i>Certificates</a>
                    @endif

                    @if(Auth::user()->role !== 'parent')
                        <a href="{{ route('mailbox.index') }}" class="nav-item nav-link {{ request()->routeIs('mailbox.*') ? 'active' : '' }}"><i class="fa fa-envelope me-2"></i>Mailbox</a>
                    @endif
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                            <span id="mailbox-badge" class="badge rounded-pill bg-danger ms-1 d-none">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0" id="mailbox-dropdown">
                            <div id="mailbox-items">
                                <a href="#" class="dropdown-item text-center py-3">No new messages</a>
                            </div>
                            <hr class="dropdown-divider">
                            <a href="{{ route('mailbox.index') }}" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notifications</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Main Content Start -->
            @yield('content')
            <!-- Main Content End -->


            <!-- Footer Start -->
            <div class="container-xxl pt-2 px-2">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->



    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


    <!-- Template Javascript -->
    <script>
        (function ($) {
            "use strict";

            // Sidebar Toggler
            $('.sidebar-toggler').click(function () {
                $('.sidebar, .content').toggleClass("open");
                $('.sidebar-overlay').toggleClass("show");
                return false;
            });
            
        })(jQuery);

        // Close Sidebar on Mobile
        function closeSidebar() {
            $('.sidebar, .content').removeClass("open");
            $('.sidebar-overlay').removeClass("show");
        }

        // Close sidebar when clicking a link on mobile
        $(document).ready(function() {
            if ($(window).width() <= 991) {
                $('.sidebar .nav-link').click(function() {
                    setTimeout(function() {
                        closeSidebar();
                    }, 200);
                });
            }
        });
    </script>
    <script>
        function checkUnreadMessages() {
            $.ajax({
                url: "{{ route('mailbox.unread-data') }}",
                method: "GET",
                success: function(response) {
                    const badge = $('#mailbox-badge');
                    const itemsContainer = $('#mailbox-items');
                    
                    if (response.count > 0) {
                        badge.text(response.count).removeClass('d-none');
                        
                        let html = '';
                        const baseUrl = "{{ url('mailbox') }}";
                        response.messages.forEach(msg => {
                            const showUrl = `${baseUrl}/${msg.id}`;
                            html += `
                                <a href="${showUrl}" class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="fw-normal mb-0">${msg.sender.name} sent a message</h6>
                                            <small class="text-muted">${msg.subject}</small>
                                        </div>
                                    </div>
                                </a>
                                <hr class="dropdown-divider">
                            `;
                        });
                        itemsContainer.html(html);
                    } else {
                        badge.addClass('d-none');
                        itemsContainer.html('<a href="#" class="dropdown-item text-center py-3">No new messages</a>');
                    }
                }
            });
        }

        $(document).ready(function() {
            checkUnreadMessages();
            // Check every 30 seconds
            setInterval(checkUnreadMessages, 30000);
        });
    </script>
    @stack('scripts')
</body>

</html>

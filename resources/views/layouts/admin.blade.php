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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --info: #0ea5e9;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f8fafc;
            --sidebar-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --card-shadow-hover: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            overflow-x: hidden;
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
            width: 280px;
            height: 100vh;
            overflow-y: auto;
            background: var(--sidebar-bg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            border-right: 1px solid #e2e8f0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.02);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .sidebar-navbar {
            padding: 1.5rem 1.25rem;
        }

        .sidebar-navbar .navbar-brand h3 {
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.5px;
            margin-bottom: 0;
        }

        .content {
            width: calc(100% - 280px);
            margin-left: 280px;
            min-height: 100vh;
            background: #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        /* Nav Item Styles */
        .sidebar .nav-link {
            padding: 12px 20px;
            margin: 4px 15px;
            color: #64748b;
            font-weight: 500;
            border-radius: 12px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: var(--primary);
            background: #f5f3ff;
        }

        .sidebar .nav-link:hover i {
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        /* Submenu Styling */
        .dropdown-menu.show {
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sidebar .dropdown-item {
            padding: 8px 15px 8px 45px;
            font-size: 0.9rem;
            color: #64748b;
            border-radius: 8px;
            margin: 2px 15px;
            transition: all 0.2s;
        }

        .sidebar .dropdown-item:hover, .sidebar .dropdown-item.active {
            color: var(--primary);
            background: #f5f3ff;
        }

        /*** Navbar ***/
        .content .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            z-index: 1040;
        }

        .sidebar-toggler {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.2s;
        }

        .sidebar-toggler:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        /* Premium Cards */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
            background: white;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Premium Buttons */
        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.3);
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
        }

        /* Badge Styling */
        .badge {
            padding: 0.5em 0.8em;
            border-radius: 6px;
            font-weight: 600;
        }

        .badge.bg-success { background-color: #dcfce7 !important; color: #166534 !important; }
        .badge.bg-danger { background-color: #fee2e2 !important; color: #991b1b !important; }
        .badge.bg-info { background-color: #e0f2fe !important; color: #075985 !important; }
        .badge.bg-warning { background-color: #fef3c7 !important; color: #92400e !important; }

        /* Responsive Behavior */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: -280px; }
            .sidebar.open { margin-left: 0; }
            .content { width: 100%; margin-left: 0; }
            .content.open { margin-left: 280px; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(15, 23, 42, 0.4);
                backdrop-filter: blur(4px);
                z-index: 1045;
            }
            .sidebar-overlay.show { display: block; }
        }

        /* Form Controls */
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Notifications Dropdown */
        .dropdown-menu-end {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 16px;
            padding: 0.5rem;
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
                <a href="{{ url('/dashboard') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa-solid fa-graduation-cap me-2"></i>EduSmart</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1" style="width: 12px; height: 12px;"></div>
                        <div class="rounded-circle overflow-hidden bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold" style="width: 45px; height: 45px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-dark fw-bold">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    @if(Auth::user()->role === 'parent')
                        <a href="{{ route('parent.dashboard') }}" class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i><span>Parent Portal</span></a>
                        <a href="{{ route('mailbox.index') }}" class="nav-link {{ request()->routeIs('mailbox.*') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i><span>Mailbox</span></a>
                    @else
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
                    @endif
                    
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('master.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-shapes"></i><span>Academic Master</span>
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
                                <i class="fa-solid fa-wallet"></i><span>Fees & Finance</span>
                            </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->routeIs('fees.*') ? 'show' : '' }}">
                            <a href="{{ route('fees.payments.create') }}" class="dropdown-item nav-link {{ request()->routeIs('fees.payments.create') ? 'active' : '' }}">Collect Fee</a>
                            <a href="{{ route('fees.payments.index') }}" class="dropdown-item nav-link {{ request()->routeIs('fees.payments.index') ? 'active' : '' }}">Payment History</a>
                        </div>
                    </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->is('staff*') || request()->is('attendance*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-tie"></i><span>Human Resources</span>
                            </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->is('staff*') || request()->is('attendance*') ? 'show' : '' }}">
                            <a href="{{ route('staff.index') }}" class="dropdown-item nav-link {{ request()->routeIs('staff.index') ? 'active' : '' }}">Staff List</a>
                            <a href="{{ route('attendance.mark') }}" class="dropdown-item nav-link {{ request()->routeIs('attendance.mark') ? 'active' : '' }}">Face Attendance</a>
                            <a href="{{ route('attendance.index') }}" class="dropdown-item nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}">Attendance Log</a>
                        </div>
                    </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('library.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-book-open-reader"></i><span>Library</span>
                            </a>
                        <div class="dropdown-menu bg-transparent border-0 ps-4 py-0 {{ request()->routeIs('library.*') ? 'show' : '' }}">
                            <a href="{{ route('library.books.index') }}" class="dropdown-item nav-link {{ request()->routeIs('library.books.*') ? 'active' : '' }}">Book List</a>
                            <a href="{{ route('library.issues.index') }}" class="dropdown-item nav-link {{ request()->routeIs('library.issues.*') ? 'active' : '' }}">Issue / Return</a>
                        </div>
                    </div>

                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear"></i><span>User Access</span></a>
                        <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"><i class="fa-solid fa-user-graduate"></i><span>Students</span></a>
                        <a href="{{ route('certificates.index') }}" class="nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}"><i class="fa-solid fa-award"></i><span>Certificates</span></a>
                    @endif

                    @if(Auth::user()->role !== 'parent')
                        <a href="{{ route('mailbox.index') }}" class="nav-link {{ request()->routeIs('mailbox.*') ? 'active' : '' }}"><i class="fa-solid fa-inbox"></i><span>Mailbox</span></a>
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

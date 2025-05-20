<?php
$base_url = '/iscp_enrollment';

/**
 * Header template for Student Enrollment System
 *
 * Should be included after session.php has been loaded.
 */

$page_title = $page_title ?? 'Student Enrollment System';
$active_page = $active_page ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />

    <!-- Bootstrap Bundle JS (with Popper) - Added here to ensure it loads before navbar interaction -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for navbar toggle functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var navbarToggler = document.querySelector('.navbar-toggler');
            var navbarCollapse = document.querySelector('.navbar-collapse');

            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', function () {
                    navbarCollapse.classList.toggle('show');
                });

                // Close menu when clicking anywhere outside
                document.addEventListener('click', function (event) {
                    var isClickInside = navbarToggler.contains(event.target) || navbarCollapse.contains(event.target);
                    if (!isClickInside && navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                });
            }
        });
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css" />

    <link rel="icon" href="<?php echo $base_url; ?>/assets/images/iscp-logo.png" type="image/png" sizes="16x16" />

    <style>
        /* Enable sticky footer layout */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 90px;
            /* Keep your navbar offset */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        main {
            flex: 1;
            /* Allow main content to grow and push footer down */
        }

        .navbar {
            height: 90px;
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 0.5px;
            font-size: 1.75rem;
            display: flex;
            align-items: center;
        }

        .nav-link.active {
            font-weight: 600;
            border-bottom: 2px solid white;
            position: relative;
            padding-bottom: 8px !important;
        }

        .nav-link.active:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);
        }

        .nav-link:not(.active):hover {
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .navbar-brand img {
            height: 60px;
            width: 60px;
            margin-right: 15px;
        }

        .navbar-nav .nav-link {
            font-size: 1.05rem;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .navbar-nav {
            align-items: center;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #0d6efd;
                padding: 10px;
                border-radius: 0 0 10px 10px;
                margin-top: 10px;
            }

            .navbar {
                height: auto;
                min-height: 90px;
            }
        }
    </style>
</head>

<body>
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?php echo htmlspecialchars($_SESSION['flash']);
            unset($_SESSION['flash']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <!-- Brand and toggle button -->
            <span class="navbar-brand d-flex align-items-center">
                <img src="<?php echo $base_url; ?>/assets/images/iscp-logo.png" class="rounded-circle me-2"
                    alt="ISCP Logo">
                ISCP Student Enrollment
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'students') ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>/pages/students.php">
                            <i class="bi bi-people me-1"></i>Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'add_student') ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>/pages/add_student.php">
                            <i class="bi bi-person-plus me-1"></i>Add Student
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'courses') ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>/pages/courses.php">
                            <i class="bi bi-book me-1"></i>Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'enroll') ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>/pages/enroll.php">
                            <i class="bi bi-pencil-square me-1"></i>Enroll
                        </a>
                    </li>
                </ul>

                <!-- User Authentication Menu -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($active_page == 'logout') ? 'active' : ''; ?>"
                                href="<?php echo $base_url; ?>/pages/logout.php">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($active_page == 'login') ? 'active' : ''; ?>"
                                href="<?php echo $base_url; ?>/pages/login.php">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="flex-grow-1">
        <div class="container py-4">
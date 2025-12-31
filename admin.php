<?php
session_start();
include "koneksi.php";

// cek login
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// halaman aktif
$currentPage = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>

    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />

    <!-- ===== UI MASKULIN & CERAH ===== -->
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #ffffff 0%, #f1f4f8 100%);
        }

        #content {
            flex: 1;
        }

        /* NAVBAR */
        .navbar {
            background: #ffffff !important;
            border-bottom: 1px solid #e5e7eb;
        }

        .navbar-brand {
            font-weight: 700;
            color: #0f172a !important;
            letter-spacing: .5px;
        }

        .nav-link {
            color: #334155 !important;
            font-weight: 500;
            transition: all .2s ease;
        }

        .nav-link:hover {
            color: #0f172a !important;
        }

        .nav-link.active {
            color: #0f172a !important;
            font-weight: 600;
            border-bottom: 3px solid #2563eb;
        }

        /* USER DROPDOWN */
        .dropdown-toggle {
            color: #2563eb !important;
            font-weight: 600;
        }

        /* FOOTER */
        footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
        }

        footer i {
            color: #334155;
            transition: all .2s ease;
        }

        footer i:hover {
            color: #2563eb;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" target="_blank" href=".">My Daily Journal</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'dashboard') ? 'active' : '' ?>"
                       href="admin.php?page=dashboard">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'article') ? 'active' : '' ?>"
                       href="admin.php?page=article">
                        Article
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        <?= htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<section id="content" class="p-5">
    <div class="container">
        <?php
        $allowedPages = ['dashboard', 'article'];

        if (in_array($currentPage, $allowedPages, true) && file_exists($currentPage . ".php")) {
            include $currentPage . ".php";
        } else {
            include "dashboard.php";
        }
        ?>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="text-center p-5">
    <div>
        <a href="https://www.instagram.com/udinusofficial">
            <i class="bi bi-instagram h2 p-2"></i>
        </a>
        <a href="https://twitter.com/udinusofficial">
            <i class="bi bi-twitter h2 p-2"></i>
        </a>
        <a href="https://wa.me/+62812685577">
            <i class="bi bi-whatsapp h2 p-2"></i>
        </a>
    </div>
    <div class="fw-semibold text-dark">devin &copy; 2023</div>
</footer>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous">
</script>

</body>
</html>

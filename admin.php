<?php
session_start();
include "koneksi.php";

// proteksi login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// halaman aktif
$currentPage = $_GET['page'] ?? 'dashboard';
$allowedPages = ['dashboard', 'article'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>

    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

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
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .navbar-brand {
            font-weight: 700;
            color: #0f172a;
            letter-spacing: .5px;
        }

        .nav-link {
            color: #334155;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #0f172a;
        }

        .nav-link.active {
            color: #0f172a;
            font-weight: 600;
            border-bottom: 3px solid #2563eb;
        }

        .dropdown-toggle {
            color: #2563eb;
            font-weight: 600;
        }

        /* FOOTER */
        footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
        }

        footer i {
            color: #334155;
            transition: .2s;
        }

        footer i:hover {
            color: #2563eb;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="admin.php">My Daily Journal</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'dashboard') ? 'active' : '' ?>"
                       href="admin.php?page=dashboard">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'article') ? 'active' : '' ?>"
                       href="admin.php?page=article">Article</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
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

<!-- CONTENT -->
<section id="content" class="p-5">
    <div class="container">
        <?php
        if (in_array($currentPage, $allowedPages, true) && file_exists($currentPage . ".php")) {
            include $currentPage . ".php";
        } else {
            include "dashboard.php";
        }
        ?>
    </div>
</section>

<!-- FOOTER -->
<!-- ================= FOOTER ================= -->
<footer class="text-center p-5">
    <div>
        <a href="https://www.instagram.com/panduupratamaaa_?igsh=MTBvNmJraTlydDZycw%3D%3D&utm_source=qr">
            <i class="bi bi-instagram h2 p-2"></i>
        </a>
        <a href="https://www.tiktok.com/@masbearr">
            <i class="bi bi-tiktok h2 p-2"></i>
        </a>
        <a href="https://wa.me/+6282329422289">
            <i class="bi bi-whatsapp h2 p-2"></i>
        </a>
    </div>
    <div class="fw-semibold text-dark">Devin Abiyyu Pandu Pratama &copy; 2025</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil 🎉',
    text: 'Data berhasil disimpan',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Dihapus 🗑️',
    text: 'Data berhasil dihapus',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil ✏️',
    text: 'Data berhasil diperbarui',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>
<script>
function confirmDelete(url) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Data tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

</body>
</html>

<?php
// dashboard.php
?>

<style>
/* ===== JUDUL HALAMAN ===== */
.page-title {
    font-weight: 700;
    letter-spacing: .5px;
}

.page-divider {
    width: 100%;
    height: 2px;
    background: linear-gradient(to right, #111827, #e5e7eb);
    border-radius: 2px;
}

/* ===== CARD DASHBOARD ===== */
.dashboard-card {
    border-radius: 14px;
    transition: transform .2s ease, box-shadow .2s ease;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0,0,0,.08);
}
</style>

<div class="container">

    <!-- ===== JUDUL DASHBOARD ===== -->
    <div class="mb-4">
        <h3 class="page-title mb-2">Dashboard</h3>
        <div class="page-divider"></div>
    </div>

    <!-- ===== CARD STATISTIK ===== -->
    <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-start">
        <div class="col">
            <div class="card dashboard-card border border-danger shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-newspaper"></i> Article
                            </h5>
                            <small class="text-muted">Total artikel</small>
                        </div>
                        <div>
                            <span class="badge rounded-pill text-bg-danger fs-3">
                                <?php echo $conn->query("SELECT COUNT(*) FROM article")->fetch_row()[0]; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

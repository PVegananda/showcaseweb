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

/* ===== TOMBOL ===== */
.btn-add {
    background: #1f2933;
    color: #fff;
    border-radius: 8px;
}

.btn-add:hover {
    background: #111827;
    color: #fff;
}

/* ===== TABEL ===== */
.table-wrapper {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
    overflow: hidden;
}

.table {
    margin-bottom: 0;
}

.table thead {
    background: #1f2933;
    color: #ffffff;
}

.table th {
    font-weight: 600;
    letter-spacing: .5px;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.table tbody tr {
    transition: background-color .2s ease;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

/* ===== GAMBAR ===== */
.table img {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}

/* ===== AKSI ===== */
.badge {
    padding: 8px 10px;
    font-size: .9rem;
}

.badge i {
    vertical-align: middle;
}
</style>

<div class="container">

    <!-- ===== JUDUL HALAMAN ===== -->
    <div class="mb-4">
        <h3 class="page-title mb-2">Article</h3>
        <div class="page-divider"></div>
    </div>

    <!-- ===== TOMBOL TAMBAH ===== -->
    <button type="button" class="btn btn-add mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Data
    </button>

    <!-- ===== TABEL ===== -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="w-25">Judul</th>
                        <th class="w-25">Isi</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                $hasil = $conn->query($sql);
                $no = 1;
                while ($row = $hasil->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <strong><?= $row["judul"] ?></strong>
                            <br><small class="text-muted">pada : <?= $row["tanggal"] ?></small>
                            <br><small class="text-muted">oleh : <?= $row["username"] ?></small>
                        </td>
                        <td><?= $row["isi"] ?></td>
                        <td>
                            <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])) { ?>
                                <img src="img/<?= $row["gambar"] ?>" width="110">
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <a href="#" class="badge rounded-pill text-bg-success"
                               data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="badge rounded-pill text-bg-danger"
                               data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

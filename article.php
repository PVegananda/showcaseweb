<?php
// article.php
?>

<style>
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

.btn-add {
    background: #1f2933;
    color: #fff;
    border-radius: 8px;
}

.btn-add:hover {
    background: #111827;
    color: #fff;
}

.table-wrapper {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
    overflow: hidden;
}

.table thead {
    background: #1f2933;
    color: #ffffff;
}

.table img {
    border-radius: 10px;
}
</style>

<div class="container">

    <!-- ===== JUDUL ===== -->
    <div class="mb-4">
        <h3 class="page-title mb-2">Article</h3>
        <div class="page-divider"></div>
    </div>

    <!-- ===== TOMBOL TAMBAH ===== -->
    <button class="btn btn-add mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Data
    </button>

    <!-- ===== TABEL ===== -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Gambar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM article ORDER BY tanggal DESC");
                $no = 1;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['judul']) ?></strong><br>
                            <small class="text-muted"><?= $row['tanggal'] ?></small><br>
                            <small class="text-muted">oleh <?= $row['username'] ?></small>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['isi'])) ?></td>
                        <td>
                            <?php if ($row['gambar']) : ?>
                                <img src="img/<?= $row['gambar'] ?>" width="100">
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="badge rounded-pill text-bg-success border-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit<?= $row['id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="badge rounded-pill text-bg-danger border-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapus<?= $row['id'] ?>">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- ================= MODAL EDIT ================= -->
                    <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form method="post" action="article_edit.php" enctype="multipart/form-data">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Artikel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <input type="text" name="judul" class="form-control"
                                                   value="<?= htmlspecialchars($row['judul']) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Isi</label>
                                            <textarea name="isi" class="form-control" rows="4" required><?= htmlspecialchars($row['isi']) ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Gambar (opsional)</label>
                                            <input type="file" name="gambar" class="form-control">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ================= MODAL HAPUS ================= -->
                    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Hapus Artikel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Yakin hapus artikel
                                    <strong><?= htmlspecialchars($row['judul']) ?></strong> ?
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form method="post" action="article_hapus.php">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
                </tbody>
            </table>

            <!-- ================= MODAL TAMBAH ================= -->
            <div class="modal fade" id="modalTambah" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form method="post" action="article_tambah.php" enctype="multipart/form-data">

                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Artikel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Isi</label>
                                    <textarea name="isi" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gambar (opsional)</label>
                                    <input type="file" name="gambar" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

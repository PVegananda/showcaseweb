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

.table tbody tr:hover {
    background-color: #f8fafc;
}

.table img {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
</style>

<div class="container">

    <div class="mb-4">
        <h3 class="page-title mb-2">Article</h3>
        <div class="page-divider"></div>
    </div>

    <button type="button" class="btn btn-add mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Data
    </button>

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
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($articles) > 0):
                    $no = 1;
                    foreach ($articles as $row):
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['judul']); ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($row['tanggal']); ?></small><br>
                            <small class="text-muted">oleh <?= htmlspecialchars($row['username']); ?></small>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['isi'])); ?></td>
                        <td>
                            <?php if (!empty($row['gambar']) && file_exists("img/".$row['gambar'])): ?>
                                <img src="img/<?= htmlspecialchars($row['gambar']); ?>" width="110">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="#" class="badge rounded-pill text-bg-success">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="badge rounded-pill text-bg-danger">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                    endforeach;
                else:
                ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada artikel
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

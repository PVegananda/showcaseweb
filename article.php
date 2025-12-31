<?php
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $upload = move_uploaded_file($_FILES['gambar']['tmp_name'], 'img/' . $nama_gambar);
        if ($upload) {
            $gambar = $nama_gambar;
        } else {
            echo "<script>alert('Gagal upload gambar');</script>";
            exit;
        }
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            if ($_POST['gambar_lama'] != '' && file_exists('img/' . $_POST['gambar_lama'])) {
                unlink('img/' . $_POST['gambar_lama']);
            }
        }

        $stmt = $conn->prepare("
            UPDATE article 
            SET judul = ?, isi = ?, gambar = ?, tanggal = ?, username = ?
            WHERE id = ?
        ");
        $simpan = $stmt->execute([$judul, $isi, $gambar, $tanggal, $username, $id]);

    } else {
        $stmt = $conn->prepare("
            INSERT INTO article (judul, isi, gambar, tanggal, username)
            VALUES (?, ?, ?, ?, ?)
        ");
        $simpan = $stmt->execute([$judul, $isi, $gambar, $tanggal, $username]);
    }

    if ($simpan) {
        echo "<script>alert('Simpan data sukses');location='admin.php?page=article';</script>";
    } else {
        echo "<script>alert('Simpan data gagal');location='admin.php?page=article';</script>";
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '' && file_exists('img/' . $gambar)) {
        unlink('img/' . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id = ?");
    $hapus = $stmt->execute([$id]);

    if ($hapus) {
        echo "<script>alert('Hapus data sukses');location='admin.php?page=article';</script>";
    } else {
        echo "<script>alert('Hapus data gagal');location='admin.php?page=article';</script>";
    }
}
?>

<div class="mb-4">
        <h3 class="page-title mb-2">Artikel</h3>
        <div class="page-divider"></div>
    </div>

<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Data
    </button>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Judul</th>
                        <th width="35%">Isi</th>
                        <th width="15%">Gambar</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                        $stmt = $conn->query("SELECT * FROM article ORDER BY tanggal DESC");
                        $no = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $row["judul"] ?></strong>
                                <br><small>pada : <?= $row["tanggal"] ?></small>
                                <br><small>oleh : <?= $row["username"] ?></small>
                            </td>
                            <td><?= $row["isi"] ?></td>
                            <td>
                                <?php if ($row["gambar"] != '') { if (file_exists('img/' . $row["gambar"] . '')) { ?>
                                        <img src="img/<?= $row["gambar"] ?>" width="100">
                                <?php }} ?>
                            </td>
                            <td>
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                                
                                <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                    <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                                    <div class="mb-3">
                                                        <label for="judul" class="form-label">Judul</label>
                                                        <input type="text" class="form-control" name="judul" value="<?= $row["judul"] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="isi" class="form-label">Isi</label>
                                                        <textarea class="form-control" name="isi" required><?= $row["isi"] ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="gambar" class="form-label">Ganti Gambar</label>
                                                        <input type="file" class="form-control" name="gambar">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="gambar" class="form-label">Gambar Lama</label>
                                                        <?php if ($row["gambar"] != '') { if (file_exists('img/' . $row["gambar"] . '')) { ?>
                                                                <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                                        <?php }} ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
                                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                        <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                                    <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi</label>
                                <textarea class="form-control" name="isi" placeholder="Tuliskan Isi Artikel" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
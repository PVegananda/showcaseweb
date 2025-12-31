<?php
include "koneksi.php";

$id    = $_POST['id'];
$judul = $_POST['judul'];
$isi   = $_POST['isi'];

if (!empty($_FILES['gambar']['name'])) {
    $nama = time() . "_" . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$nama");

    $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, gambar=? WHERE id=?");
    $stmt->execute([$judul, $isi, $nama, $id]);
} else {
    $stmt = $conn->prepare("UPDATE article SET judul=?, isi=? WHERE id=?");
    $stmt->execute([$judul, $isi, $id]);
}

header("Location: admin.php?page=article&updated=1");
exit;


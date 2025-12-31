<?php
session_start();
include "koneksi.php";

// keamanan
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$judul    = $_POST['judul'];
$isi      = $_POST['isi'];
$username = $_SESSION['username'];
$gambar   = null;

// jika upload gambar
if (!empty($_FILES['gambar']['name'])) {
    $gambar = time() . "_" . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "img/$gambar");
}

// insert ke database
$stmt = $conn->prepare("
    INSERT INTO article (judul, isi, gambar, tanggal, username)
    VALUES (?, ?, ?, NOW(), ?)
");

$stmt->execute([
    $judul,
    $isi,
    $gambar,
    $username
]);

header("Location: admin.php?page=article");
exit;

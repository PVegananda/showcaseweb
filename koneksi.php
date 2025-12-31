<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; // default brew biasanya kosong
$db   = "crud_artikel";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

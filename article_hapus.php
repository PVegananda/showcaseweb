<?php
include "koneksi.php";

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM article WHERE id=?");
$stmt->execute([$id]);

header("Location: admin.php?page=article");

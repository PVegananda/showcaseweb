<?php
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQL_DATABASE'); // ← INI PENTING
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

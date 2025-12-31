<?php
try {
    $host = getenv("MYSQLHOST");
    $db   = getenv("MYSQLDATABASE"); // ← INI PENTING
    $user = getenv("MYSQLUSER");
    $pass = getenv("MYSQLPASSWORD");
    $port = getenv("MYSQLPORT");

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    $conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

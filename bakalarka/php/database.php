<?php

$host = '127.0.0.1';
$port = 3307;
$dbName = 'bakalarka';
$user = 'root';
$password = '123';

$dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password , [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Connection to database failed: " . $e->getMessage());
}
<?php
require_once __DIR__ . '/../databaseConections/database.php';

$username = '---';
$password = '---*';
$rola = '---';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO Admins (username, password_hash, role)
    VALUES (:username, :password, :rola)
");

$stmt->execute([
    ':username' => $username,
    ':password' => $hashedPassword,
    ':rola' => $rola
]);

echo 'Pouzivatel vytvoreny';
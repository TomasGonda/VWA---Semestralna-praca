<?php

session_start();

require_once __DIR__ . '../databaseConections/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$sessionToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_POST['csrf_token'] ?? '';

if (!is_string($sessionToken) || !is_string($submittedToken) || $sessionToken === '' || !hash_equals($sessionToken, $submittedToken)) {
    header('Location: login.php?error=invalid_csrf_token');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: login.php?error=empty_fields');
    exit;
}

$sql = "Select id, username, password_hash from admins where username = :username limit 1";

$stmt = $pdo->prepare($sql);

$stmt->execute(['username' => $username]);

$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password_hash'])) {
    header('Location: login.php?error=invalid_credentials');
    exit;
}

session_regenerate_id(true);

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];


$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

header('Location: admin.php');
exit;
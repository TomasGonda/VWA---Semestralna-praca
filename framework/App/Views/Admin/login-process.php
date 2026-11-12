<?php

session_start();

use Framework\DB\Connection;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: adminLogin.php');
    exit;
}

$sessionToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_POST['csrf_token'] ?? '';

if (
    !is_string($sessionToken) ||
    !is_string($submittedToken) ||
    $sessionToken === '' ||
    !hash_equals($sessionToken, $submittedToken)
) {
    header('Location: adminLogin.php?error=invalid_csrf_token');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: adminLogin.php?error=empty_fields');
    exit;
}

$db = Connection::getInstance();

$sql = "SELECT id, username, password_hash
        FROM admins
        WHERE username = :username
        LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->execute(['username' => $username]);

$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password_hash'])) {
    header('Location: adminLogin.php?error=invalid_credentials');
    exit;
}

session_regenerate_id(true);

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

header('Location: ' . $link->url("home.index"));
exit;
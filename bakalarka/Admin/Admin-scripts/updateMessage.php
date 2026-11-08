<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ../adminLogin.php');
    exit;
}

require_once __DIR__ . '/../../databaseConections/database.php';

$sessionToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_POST['csrf_token'] ?? '';

if (!is_string($sessionToken) ||
    !is_string($submittedToken) || 
    $sessionToken === '' || 
    !hash_equals($sessionToken, $submittedToken)) {
    die ('Neplatná požiadavka');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$isResolved = filter_input(INPUT_POST, 'is_resolved', FILTER_VALIDATE_INT);

if (!$id || !in_array($isResolved, [0, 1], true)) {
    die ('Neplatné údaje');
}

$sql = "Update contact set is_resolved = :is_resolved where id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'is_resolved' => $isResolved,
    'id' => $id
]);

header('Location: ../adminFormular.php');
exit;
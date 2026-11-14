<?php

session_start();

if (
    !isset($_SESSION['admin_id']) ||
    !in_array($_SESSION['admin_role'], ['admin', 'dev'], true)
) {
    header('Location: ../Pages/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Admin/admin-files.php');
    exit;
}

$sessionToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_POST['csrf_token'] ?? '';

if (!is_string($sessionToken) ||
    !is_string($submittedToken) || 
    $sessionToken === '' || 
    !hash_equals($sessionToken, $submittedToken)) {
    die ('Neplatná požiadavka');
}
$id = filter_input(INPUT_POST, 'id_document', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die ('Neplatné ID správy');    
}

require_once __DIR__ . '/../../databaseConections/database.php';

$sql = "Delete from document where id_document = :id_document";
$stmt = $pdo->prepare($sql);
$stmt -> execute ([
    ':id_document' => $id
]);

header('Location: ../admin-files.php');
exit;
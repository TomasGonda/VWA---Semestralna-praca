<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

function respond(bool $success, string $message, int $status = 200): never
{
    http_response_code($status);

    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Nepovolená metóda.', 405);
}

if ( !isset($_SESSION['admin_id']) ||
    ($_SESSION['admin_role'] ?? '') !== 'dev'
) {
    respond(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
}

$sessionToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_POST['csrf_token'] ?? '';

if (
    !is_string($sessionToken) ||
    !is_string($submittedToken) ||
    $sessionToken === '' ||
    !hash_equals($sessionToken, $submittedToken)
) {
    respond(false, 'Neplatná požiadavka.', 403);
}

if (!isset($_FILES['document'])) {
    respond(false, 'Nebol nahratý žiadny dokument');
}
$file = $_FILES['document'];

if ($file['error' !== UPLOAD_ERR_OK]) {
    respond(false, 'Pri nahravani dokumentu nastala chyba');
}

$maxSize = 12 * 1024 * 1024;

if ($file['size'] > $maxSize) {
    respond(false, 'MAximálna povolená veľkosť súboru je 12MB');
}

if ($file['size'] <= 0) {
    respond(false, 'Súbor je prázdny');
}
//TOOD Overenie či je to pdf, mine typ, pdf hlavička, poznámka, kontrola názvu súboru, úpresunutie na server a uloženie do databázy



require_once __DIR__ . '/../../databaseConections/database.php';


exit;
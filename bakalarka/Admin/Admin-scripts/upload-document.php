<?php

session_start();
//echo 'nacitalo ma';
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

if ($file['error'] !== UPLOAD_ERR_OK) {
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

$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($extension !== 'pdf') {
    respond(false, 'Povolené sú iba .pdf súbory');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mineType = $finfo->file($file['tmp_name']);

if ($mineType !== 'application/pdf') {
    respond(false, 'Nahratý súbor nie je platné pdf');
}

$translationSk = trim($_POST['translation_sk'] ?? '');

if (mb_strlen($translationSk) > 255) {
    respond(false, 'Poznámka môže mať max 255 znakov');
}

require_once __DIR__ . '/../../databaseConections/database.php';

$uploadDirectory = dirname(__DIR__, 2). '../../shared/documents/';

$newFileName = bin2hex(random_bytes(16)) . 'pdf';

$fileDest = $uploadDirectory . $newFileName;

$relativePath = '../../shared/documents/' . $newFileName;

if (!move_uploaded_file($file['tmp_name'], $fileDest)) {
    respond(false, 'Nepodarilo sa nahrať dokument na server', 500);
}

try {
    $stmt = $pdo->prepare(
        "insert into document (file_name, file_path, note)
        values (:file_name, :file_path, :note)"
    );
    
    $stmt->execute([
        ':file_name' => basename($file['name']),
        ':file_path' => $relativePath,
        ':note' => $translationSk
    ]);

    respond(true, 'Dokument sa úspečne nahral');
} catch (PDOException $e) {
    if (file_exists($fileDest)) {
        unlink($fileDest);
    }

    error_log('Upload document error: ' . $e->getMessage());

    respond(false, 'Nepodarilo sa uložiť dokument dodatabázy');
}

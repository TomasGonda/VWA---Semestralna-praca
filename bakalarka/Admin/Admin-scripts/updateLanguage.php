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

if (!isset($_SESSION['admin_id'])) {
    respond(false, 'Nie ste prihlásený.', 401);
}

require_once __DIR__ . '/../../databaseConections/database.php';


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

$id_sk = filter_input(INPUT_POST, 'id_sk', FILTER_VALIDATE_INT);
$id_en = filter_input(INPUT_POST, 'id_en', FILTER_VALIDATE_INT);

$sk = trim($_POST['sk'] ?? '');
$en = trim($_POST['en'] ?? '');

if (!$id_sk || !$id_en || $sk === '' || $en === '') {
    respond(false, 'Neplatné údaje.', 400);
}

try {
    $pdo->beginTransaction();

    $sql = 'update translations set translation_value = :value
            where id = :id';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':value' => $sk,
        ':id' => $id_sk
    ]);

    $stmt->execute([
        ':value' => $en,
        ':id' => $id_en
    ]);

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    respond(false, 'Preklad sa nepodarilo uložiť.', 500);
    header('Location: ../admin-translations.php#translation-' . $id_sk);
}
respond(true, 'Preklad sa úspešne uložil.');
header('Location: ../admin-translations.php#translation-' . $id_sk);
exit;
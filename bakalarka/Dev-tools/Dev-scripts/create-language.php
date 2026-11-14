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

if ( !isset($_SESSION['admin_id']) ||
    ($_SESSION['admin_role'] ?? '') !== 'dev'
) {
    respond(false, 'Nemáte oprávnenie vykonať túto akciu.', 403);
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

$translation_key = trim($_POST['translation_key_form'] ?? '');
$sk = trim($_POST['translation_sk'] ?? '');
$en = trim($_POST['translation_en'] ?? '');
/*var_dump($_POST);
exit;*/
error_log('KEY: ' . $translation_key);
error_log('SK: ' . $sk);
error_log('EN: ' . $en);

if ($translation_key === '' || $sk ==='' || $en ==='') {
    respond(false, 'Vyplňte všetky polia.', 400);
}

try {
    $pdo->beginTransaction();

    $languageSql = 'select code, id from languages where code in ("sk","en")';
    $languageStmt = $pdo->query($languageSql);
    $languages = $languageStmt->fetchAll(PDO::FETCH_KEY_PAIR);

    if (!isset($languages['sk']) || !isset($languages['en'])) {
        throw new Exception('Jazyky SK alebo EN neboli nájdené');
    }

    $checkSql = 'select count(*) from translations where translation_key = :key';
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':key' => $translation_key]);

    if ((int) $checkStmt->fetchColumn() >0 ) {
        $pdo->rollBack();
        respond(false, 'Tento tag už existuje.', 409);
    }
    $insertSql = 'insert into translations(language_id, translation_key, translation_value) 
                    values (:language_id, :key, :value)';

    $insertStmt = $pdo->prepare($insertSql);
    $insertStmt->execute([
        ':language_id' => $languages['sk'],
        ':key' =>$translation_key,
        ':value' =>$sk
    ]);

    $insertStmt->execute([
        ':language_id' => $languages['en'],
        ':key' =>$translation_key,
        ':value' =>$en
    ]);

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());
    respond(false, 'Preklad sa nepodarilo vytvoriť.', 500);
}
respond(true, 'Preklad sa úspešne vytvoril.');
exit;
<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

require_once __DIR__ . '/database.php';

header('Content-Type: application/json; charset=utf-8');

$method = strtoupper($_SERVER['REQUEST_METHOD']);
$language = $_POST['language'] ?? 'sk';

if (!in_array($language, ['sk', 'en'], true)) {
    $language = 'sk';
}
function respond(PDO $pdo, string $key, string $language, bool $success = false): void
{
    $sql = "
        SELECT t.translation_value
        FROM Translations t
        JOIN Languages l ON t.language_id = l.id
        WHERE t.translation_key = :translation_key
        AND l.code = :language
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'translation_key' => 'contact_' . $key,
        'language' => $language
    ]);

    $message = $stmt->fetchColumn();

    if ($message === false) {
        $message = $language === 'en'
            ? 'An error occurred. Please try again.'
            : 'Nastala chyba. Skúste to znova.';
    }

    echo json_encode([
        'success' => $success,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

if ($method !== 'POST') {
    respond($pdo, 'error', $language);
}

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$note = trim($_POST['note'] ?? '');
$gdprConsent = isset($_POST['gdpr']) ? 1 : 0;


if (
    $firstName === '' ||
    $lastName === '' ||
    $email === '' ||
    $phone === '' ||
    $note === ''
) {
    respond($pdo, 'required', $language);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond($pdo, 'invalid_email', $language);
}

if (!preg_match('/^\+[1-9][0-9]{0,2}(?:[ ]?[0-9]){6,12}$/', $phone)) {
    respond($pdo, 'invalid_phone', $language);
}

if (
    mb_strlen($firstName) > 100 ||
    mb_strlen($lastName) > 100 ||
    mb_strlen($email) > 254 ||
    mb_strlen($phone) > 30 ||
    mb_strlen($note) > 5000
) {
    respond($pdo, 'too_long', $language);
}

if (!isset($_POST['gdpr'])) {
    respond($pdo, 'gdpr_required', $language);
}

try {
    $sql = "
    INSERT INTO Contact
        (first_name, last_name, email, phone, note, gdpr_consent)
    VALUES
        (:first_name, :last_name, :email, :phone, :note, :gdpr_consent)
";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'note' => $note,
        'gdpr_consent' => $gdprConsent
    ]);
    respond($pdo, 'success', $language, true);
} catch (PDOException $e) {
    respond($pdo, 'error', $language);
}

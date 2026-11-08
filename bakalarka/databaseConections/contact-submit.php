<?php

require_once __DIR__ . '/database.php';

$method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($method !== 'POST') {
    if ($language === 'en') {
        die("Invalid request!");
    } else {
        die("Neplatná požiadavka!");
    }
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
    $note === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    if ($language === 'en') {
        die('Please fill in all fields correctly.');
    } else {
        die('Vyplňte správne všetky polia.');
    }
}

if (
    mb_strlen($firstName) > 100 ||
    mb_strlen($lastName) > 100 ||
    mb_strlen($email) > 254 ||
    mb_strlen($phone) > 30 ||
    mb_strlen($note) > 5000
) {
    if ($language === 'en') {
        die('Some of the data is too long.');
    } else {
         die('Niektoré údaje sú príliš dlhé.'); 
    }
}

if (!isset($_POST['gdpr'])) {
    if ($language === 'en') {
        die("You must consent to the processing of personal data.");
    } else { 
        die("Musíte súhlasiť so spracovaním osobných údajov.");
    }
}

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

header('Location: ../contact.php?status=success');
exit;
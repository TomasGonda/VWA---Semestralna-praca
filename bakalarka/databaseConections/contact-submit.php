<?php

require_once __DIR__ . '/database.php';

$method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($method !== 'POST') {
    die("Neplatná požiadavka!");
}

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$note = trim($_POST['note'] ?? '');


if (
    $firstName === '' ||
    $lastName === '' ||
    $email === '' ||
    $phone === '' ||
    $note === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    die('Vyplňte správne všetky polia.');
}

if (
    mb_strlen($firstName) > 100 ||
    mb_strlen($lastName) > 100 ||
    mb_strlen($email) > 254 ||
    mb_strlen($phone) > 30 ||
    mb_strlen($note) > 5000
) {
    die('Niektoré údaje sú príliš dlhé.');
}

$sql = "
    INSERT INTO Contact
        (first_name, last_name, email, phone, note)
    VALUES
        (:first_name, :last_name, :email, :phone, :note)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'first_name' => $firstName,
    'last_name' => $lastName,
    'email' => $email,
    'phone' => $phone,
    'note' => $note
]);

header('Location: ../contact.php?status=success');
exit;
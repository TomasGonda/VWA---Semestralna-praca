<?php
session_start();

if (($_SESSION['admin_role'] ?? '') !== 'dev') {
    header('Location: ../Pages/index.php');
    exit;
}

require_once __DIR__ . '/../databaseConections/database.php'; ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../shared/css/global.css">
    <link rel="stylesheet" href="../../shared/css/Admin/adminInterface.css">
</head>

<body>
    <main>
    </main>
</body>
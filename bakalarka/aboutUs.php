<?php
require_once __DIR__ . '/phpComponents/database_ini.php';
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>

    <link rel="stylesheet" href="../shared/css/global.css">
    <link rel="stylesheet" href="../shared/css/top-section.css">
    <link rel="stylesheet" href="../shared/css/top-responsivity.css">
    <link rel="stylesheet" href="../shared/css/main-section.css">
    <link rel="stylesheet" href="../shared/css/main-responsivity.css">
</head>

<body>
    <?php require_once __DIR__ . '/phpComponents/top-section.php'; ?>
    <section>
        <div class="main-columns">
            <div class="main-left">
                <h2>
                    <?= htmlspecialchars($translations['about'] ?? "O nás") ?>
                </h2>
                <p>Placeholder text</p>

            </div>

            <div class="main-right">
                <h2>
                    <?= htmlspecialchars($translations['documents'] ?? "Dokumenty") ?>
                </h2>
            </div>
        </div>
    </section>

</body>


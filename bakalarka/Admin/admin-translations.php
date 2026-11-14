<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Admin/adminLogin.php');
    exit;
}

require_once __DIR__ . '/../databaseConections/database.php';

/*Vygenerovany sql*/
$sql = "SELECT
    t_sk.translation_key,
    t_sk.translation_value AS sk,
    t_en.translation_value AS en
    FROM translations t_sk
    JOIN languages l_sk ON l_sk.id = t_sk.language_id
    JOIN translations t_en ON t_en.translation_key = t_sk.translation_key
    JOIN languages l_en ON l_en.id = t_en.language_id
    WHERE l_sk.code = 'sk'
    AND l_en.code = 'en'
    ORDER BY t_sk.translation_key";

$stmt = $pdo->query($sql);
$translations = $stmt->fetchAll(); ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správy | Administrácia LGR</title>

    <link rel="stylesheet" href="../../shared/css/global.css">
    <link rel="stylesheet" href="../../shared/css/Admin/adminInterface.css">

</head>

<body>
    <main>
        <div class="admin-messages">
            <h1>Preklady</h1>
            <a href="../Pages/index.php">Späť na hlavnú stránku</a>
            <div class="form-list">
                 <?php foreach ($translations as $translation): ?>
                    <article class="form-card">
                        <h2>
                        <?= htmlspecialchars(
                            $translation['translation_key']
                        ) ?>
                    </h2>
                    <p>
                        <p>
                            sk
                        </p>
                        <?= htmlspecialchars(
                            $translation['sk']
                        ) ?>
                    </p>

                    <p>
                        <p>
                            en
                        </p>
                        <?= htmlspecialchars(
                            $translation['en']
                        ) ?>
                    </p>
            </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
<?php
session_start();
if (
    !isset($_SESSION['admin_id']) ||
    !in_array($_SESSION['admin_role'], ['admin', 'dev'], true)
) {
    header('Location: ../Pages/index.php');
    exit;
}

require_once __DIR__ . '/../databaseConections/database.php';

/*Vygenerovany sql*/
$sql = "SELECT
    t_sk.translation_key AS tk,
    t_sk.translation_value AS sk,
    t_en.translation_value AS en,
    t_sk.id AS id_sk,
    t_en.id AS id_en
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
    <link rel="stylesheet" href="../../shared/css/Admin/adminTranslations.css">
    <script>
        const BASE_URL = "../../shared/";
    </script>

</head>

<body>
    <main>
        <div class="admin-messages">
            <h1>Preklady</h1>
            <a href="../Pages/index.php">Späť na hlavnú stránku</a>
            <div class="form-list">
                <?php if (($_SESSION['admin_role'] ?? '') === 'dev'): ?>
                    <article class="form-card">
                        <h2>Vytvoriť nový</h2>

                        <form class="admin-form create-translation" data-url="../Dev-tools/Dev-scripts/manage-language.php"
                            method="POST">

                            <input type="hidden" name="action" value="create">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <div class="translation-forms">
                                <label>Tag:</label>
                                <input type="text" name="translation_key_form" required>

                                <label>SK:</label>
                                <input type="text" name="translation_sk" required>

                                <label>EN:</label>
                                <input type="text" name="translation_en" required>

                                <button type="submit">Vytvoriť preklad</button>
                            </div>

                            <p class="form-message" hidden></p>
                        </form>
                    </article>
                <?php endif ?>

                <article class="form-card">
                    <h2>Hľadať</h2>
                    <form id="translation-search">
                        <input type="search" id="search-input" placeholder="Zadaj tag prekladu...">
                        <button type="submit">Hľadať</button>
                    </form>
                    <p id="search-message" hidden></p>
                </article>

                <?php foreach ($translations as $translation): ?>
                    <article class="form-card translation-card" id="translation-<?= htmlspecialchars($translation['tk']) ?>"
                        data-tag="<?= htmlspecialchars($translation['tk']) ?>">
                        <form class="admin-form edit-translation" data-url="Admin-scripts/updateLanguage.php" method="POST">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="id_sk" value="<?= (int) $translation['id_sk'] ?>">
                            <input type="hidden" name="id_en" value="<?= (int) $translation['id_en'] ?>">

                            <div class="translation-forms">
                                <h2>
                                    Tag: <?= htmlspecialchars($translation['tk']) ?>
                                </h2>

                                <label>SK:</label>
                                <input type="text" name="sk" value="<?= htmlspecialchars($translation['sk']) ?>"><br>

                                <label>EN:</label>
                                <input type="text" name="en" value="<?= htmlspecialchars($translation['en']) ?>"><br>
                                <button type="submit">Uložiť zmeny</button>
                            </div>
                            <p class="form-message" hidden></p>
                        </form>
                        <?php if (($_SESSION['admin_role'] ?? '') === 'dev'): ?>
                            <form class="admin-form delete-translation" data-url="../Dev-tools/Dev-scripts/manage-language.php"
                                method="POST" onsubmit="return confirm('Naozaj chcete vymazať tento preklad?');">

                                <input type="hidden" name="action" value="delete">

                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                <input type="hidden" name="id_sk" value="<?= (int) $translation['id_sk'] ?>">
                                <input type="hidden" name="id_en" value="<?= (int) $translation['id_en'] ?>">

                                <button type="submit" class="delete-button">
                                    Vymazať preklad
                                </button>

                                <p class="form-message" hidden></p>
                            </form>
                        <?php endif ?>
                    </article>

                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script src="../../shared/js/Admin-js/admin-translations-ajax.js"></script>
    <script src="../../shared/js/Admin-js/admin-scripts.js"></script>
</body>
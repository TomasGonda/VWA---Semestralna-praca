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

$sql = 'select id_document, document, note, timestamp from document';

$stmt = $pdo->query($sql);
$documents = $stmt->fetchAll(); ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../shared/css/global.css">
    <link rel="stylesheet" href="../../shared/css/Admin/adminTranslations.css">
    <link rel="stylesheet" href="../../shared/css/Admin/admin-file.css">

</head>

<body>
    <main>
        <div class="admin-messages">
            <h1>Správa súborov</h1>
            <a href="../Pages/index.php">Späť na hlavnú stránku</a>
            <div class="form-list">
                <h2>Nahrať nový dokument</h2>
                <article class="form-card">
                    <form class="admin-form upload-document" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                        <div class="translation-forms">
                            <div class="drop-zone" id="document-drop-zone">
                                <input type="file" name="document" id="document-input" accept=".pdf" required hidden>

                                <div class="drop-zone-content">
                                    <span class="drop-zone-icon">📄</span>
                                    <p>Presuň sem PDF súbor</p>
                                </div>
                            </div>

                            <p id="document-name" class="document-name"></p>

                            <label>Poznámka:</label>
                            <input type="text" name="translation_sk">

                            <button type="submit">Uložiť súbor</button>


                        </div>

                        <p class="form-message" hidden></p>
                    </form>
                </article>
                <?php foreach ($documents as $document): ?>
                    <article class="form-card">
                        <form class="admin-form edit-document" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id_document" value="<?= (int) $document['id_document'] ?>">

                            <div class="document-forms">
                                <h2>
                                    Dokument #<?= (int) $document['id_document'] ?>
                                </h2>

                                <label>Dokument:</label>
                                <input type="file" name="document">

                                <label>Poznámka:</label>
                                <input type="text" name="note" value="<?= htmlspecialchars($document['note'] ?? '') ?>">

                                <p>
                                    Nahraný:
                                    <?= htmlspecialchars($document['timestamp']) ?>
                                </p>

                                <button type="submit">Uložiť zmeny</button>
                            </div>

                            <p class="form-message" hidden></p>
                        </form>

                        <?php if (($_SESSION['admin_role'] ?? '') === 'dev'): ?>
                            <form method="POST" action="../Dev-tools/Dev-scripts/delete-document.php"
                                onsubmit="return confirm('Naozaj chcete vymazať tento dokument?');">

                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                <input type="hidden" name="id_document" value="<?= (int) $document['id_document'] ?>">

                                <button type="submit" class="delete-button">
                                    Vymazať dokument
                                </button>
                            </form>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>

            </div>

        </div>
    </main>
    <script src="../../shared/js/Admin-js/admin-upload-file.js"></script>
</body>
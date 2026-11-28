<?php
$view->setLayout(null);
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správy | Administrácia LGR</title>

    <link rel="stylesheet" href="<?= $link->asset('css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminTranslations.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/admin-scripts.css') ?>">
    <script>
        const BASE_URL = "";
    </script>

</head>

<body>
    <main>
        <div class="admin-messages">
            <h1>Preklady</h1>
            <a href="<?= $link->url("home.index") ?>">Späť na hlavnú stránku</a>
            <div class="form-list">
                <?php if (($_SESSION['role'] ?? '') === 'dev'): ?>
                    <h2>Vytvoriť nový</h2>
                    <article class="form-card">
                        <form class="admin-form create-translation" data-url="<?= $link->url('admin.createLanguage') ?>"
                            method="POST">

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

                <?php foreach ($translations as $translation): ?>
                    <article class="form-card">
                        <form class="admin-form edit-translation" data-url="<?= $link->url('admin.updateLanguage') ?>"
                            method="POST">

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
                        <?php if (($_SESSION['role'] ?? '') === 'dev'): ?>
                            <form method="POST" action="<?= $link->url('admin.deleteLanguage') ?>"
                                onsubmit="return confirm('Naozaj chcete vymazať tento preklad?');">

                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                <input type="hidden" name="id" value="<?= (int) $translation['id_sk'] ?>">
                                <input type="hidden" name="id" value="<?= (int) $translation['id_en'] ?>">

                                <button type="submit" class="delete-button">
                                    Vymazať preklad
                                </button>
                            </form>
                        <?php endif ?>
                    </article>

                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script src="<?= $link->asset('js/Admin-js/admin-scripts.js') ?>" defer></script>
</body>
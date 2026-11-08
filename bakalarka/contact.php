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
        <form class="contact-form" method="post" action="?c=contact&a=submit">
            <div class="form-group">
                <label for="first_name"><?= htmlspecialchars($translations['first_name_label'] ?? "Meno") ?></label>
                <input type="text" id="first_name" name="first_name"
                    placeholder="<?= htmlspecialchars($translations['first_name_placeholder'] ?? "Meno") ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name"><?= htmlspecialchars($translations['last_name_label'] ?? "Priezvisko") ?></label>
                <input type="text" id="last_name" name="last_name"
                    placeholder="<?= htmlspecialchars($translations['last_name_placeholder'] ?? "Priezvisko") ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><?= htmlspecialchars($translations['email_label'] ?? "E-Mail") ?></label>
                <input type="email" id="email" name="email"
                    placeholder="<?= htmlspecialchars($translations['email_placeholder'] ?? "Email") ?>" required>
            </div>

            <div class="form-group">
                <label for="phone"><?= htmlspecialchars($translations['phone_label'] ?? "Telefón") ?></label>
                <input type="tel" id="phone" name="phone"
                    placeholder="<?= htmlspecialchars($translations['phone_placeholder'] ?? "+421 900 123 456") ?>" required>
            </div>

            <div class="form-group">
                <label for="note"><?= htmlspecialchars($translations['note_label'] ?? "Poznámka") ?></label>
                <textarea id="note" name="note" rows="5"
                    placeholder="<?= htmlspecialchars($translations['note_placeholder'] ?? "Poznámka pre firmu") ?>" required></textarea>
            </div>

            <button type="submit"><?= htmlspecialchars($translations['submit_button'] ?? "Odoslať") ?></button>
        </form>
    </section>
    
</body>

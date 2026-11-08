<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'LGR' ?></title>

    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/top-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/top-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/main-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/main-responsivity.css') ?>">
</head>

<body>
    <section class="contact-section">
        <div class="contact-columns">
            <form class="contact-form" method="post" action="?c=contact&a=submit">
                <div class="form-group">
                    <label
                        for="first-name"><?= htmlspecialchars($translations['first_name_label'] ?? "Meno", ENT_QUOTES, "UTF-8") ?></label>
                    <input type="text" id="first_name" name="first_name"
                        placeholder=<?= htmlspecialchars($translations['first_name_placeholder'] ?? "Meno", ENT_QUOTES, "UTF-8") ?> required>
                </div>

                <div class="form-group">
                    <label
                        for="last-name"><?= htmlspecialchars($translations['last_name_label'] ?? "Priezvisko", ENT_QUOTES, "UTF-8") ?></label>
                    <input type="text" id="last_name" name="last_name"
                        placeholder=<?= htmlspecialchars($translations['last_name_label'] ?? "Priezvisko", ENT_QUOTES, "UTF-8") ?> required>
                </div>

                <div class="form-group">
                    <label
                        for="email"><?= htmlspecialchars($translations['email_label'] ?? "E-Mail", ENT_QUOTES, "UTF-8") ?></label>
                    <input type="email" id="email" name="email"
                        placeholder=<?= htmlspecialchars($translations['email_placeholder'] ?? "Email", ENT_QUOTES, "UTF-8") ?> required>
                </div>

                <div class="form-group">
                    <label
                        for="phone"><?= htmlspecialchars($translations['phone_label'] ?? "Telefón", ENT_QUOTES, "UTF-8") ?></label>
                    <input type="tel" id="phone" name="phone"
                        placeholder=<?= htmlspecialchars($translations['phone_placeholder'] ?? "+421 900 123 456", ENT_QUOTES, "UTF-8") ?> required>
                </div>

                <div class="form-group">
                    <label
                        for="note"><?= htmlspecialchars($translations['note_label'] ?? "Poznámka", ENT_QUOTES, "UTF-8") ?></label>
                    <textarea type="note" id="note" name="note" rows="5"
                        placeholder=<?= htmlspecialchars($translations['note_placeholder'] ?? "Poznámka pre firmu", ENT_QUOTES, "UTF-8") ?> required></textarea>
                </div>

                <button
                    type="submit"><?= htmlspecialchars($translations['submit_button'] ?? "Odoslať", ENT_QUOTES, "UTF-8") ?></button>
            </form>

            <div class="contact-info">

            </div>
        </div>
    </section>
</body>
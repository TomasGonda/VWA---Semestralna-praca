<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'LGR' ?></title>

    <link rel="stylesheet" href="<?= $link->asset('css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/adminLogin.css') ?>">
</head>

<body>
    <section class="contact-section">
        <div class="main-columns">
            <form class="contact-form" method="post" action="?c=contact&a=submit">
                <p id="contact-message" class="form-message" hidden></p>
                <div class="form-group">
                    <label for="first_name">
                        <?= htmlspecialchars($translations['first_name_label'] ?? "Meno") ?>
                    </label>
                    <input type="text" id="first_name" name="first_name"
                        placeholder="<?= htmlspecialchars($translations['first_name_placeholder'] ?? "Meno") ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="last_name">
                        <?= htmlspecialchars($translations['last_name_label'] ?? "Priezvisko") ?>
                    </label>
                    <input type="text" id="last_name" name="last_name"
                        placeholder="<?= htmlspecialchars($translations['last_name_placeholder'] ?? "Priezvisko") ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">
                        <?= htmlspecialchars($translations['email_label'] ?? "E-Mail") ?>
                    </label>
                    <input type="email" id="email" name="email"
                        placeholder="<?= htmlspecialchars($translations['email_placeholder'] ?? "Email") ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">
                        <?= htmlspecialchars($translations['phone_label'] ?? "Telefón") ?>
                    </label>
                    <input type="tel" id="phone" name="phone"
                        placeholder="<?= htmlspecialchars($translations['phone_placeholder'] ?? "+421 900 123 456") ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="note">
                        <?= htmlspecialchars($translations['note_label'] ?? "Poznámka") ?>
                    </label>
                    <textarea id="note" name="note" rows="5"
                        placeholder="<?= htmlspecialchars($translations['note_placeholder'] ?? "Poznámka pre firmu") ?>"
                        required></textarea>
                </div>

                <div class="gdpr-form">
                    <input type="checkbox" id="gdpr" name="gdpr" value="1" required>
                        <?= htmlspecialchars($translations['gdpr_consent'] ?? "Súhlasím so spracovaním osobných údajov.") ?>
                    <label for="gdpr">

                    </label>

                </div>

                <button type="submit">
                    <?= htmlspecialchars($translations['submit_button'] ?? "Odoslať") ?>
                </button>
            </form>

            <div class="main-right">
                <h2>
                    <?= htmlspecialchars($translations['contact_info_title'] ?? "Kontaktujte nás") ?>
                </h2>
                <p>
                    <?= nl2br(htmlspecialchars($translations['contact_info_address'] ?? " Adresa:
                    Na Stráňach 6
                    971 01 PRIEVIDZA
                    Slovenská republika")) ?>
                </p>
                <p>
                    <?= nl2br(htmlspecialchars($translations['contact_info_phone'] ?? "Telefón: 
                    +421 905 627 189")) ?>
                </p>
                <p>
                    <?= nl2br(htmlspecialchars($translations['contact_info_email'] ?? "E-Mail: 
                    info@lgr.sk")) ?>
                </p>

                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3344.036535606584!2d18.63285427677441!3d48.77988060622744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4714dcfae5473b53%3A0x64f0eec29c9c5141!2sLGR%20electronic%2C%20spol.%20s%20r.o.!5e1!3m2!1ssk!2ssk!4v1794139136547!5m2!1ssk!2ssk"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>
                </div>

            </div>
        </div>
    </section>
    <script src="<?= $link->asset('js/ajax-contact.js') ?>" defer></script>
</body>
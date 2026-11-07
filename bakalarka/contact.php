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
    <?php require_once __DIR__ . '/php/top-section.php'; ?>
<section>
    <form class="contact-form" method="POST" action="php/contact-submit.php">
        <div class="form-group">
            <label for="first-name">Meno</label>
            <input type="text" id="first_name" name="first_name" placeholder="Zadajte meno" required>
        </div>

        <div class="form-group">
            <label for="last-name">Priezvisko</label>
            <input type="text" id="last_name" name="last_name" placeholder="Zadajte priezvisko" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="phone">Telefón</label>
            <input type="tel" id="phone" name="phone" placeholder="+421 900 123 456" required>
        </div>

        <div class="form-group">
            <label for="note">Poznámka</label>
            <textarea type="note" id="note" name="note" rows="5" placeholder="Poznámka pre firmu" required></textarea>
        </div>

        <button type="submit">Odoslať</button>
    </form>

</section>
</body>

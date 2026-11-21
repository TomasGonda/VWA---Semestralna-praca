<?php
$view->setLayout(null);



if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie administrátora | LGR</title>
    <link rel="stylesheet" href="<?= $link->asset('css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminLogin.css') ?>">
</head>

<body>
    <main class="admin-login-container">

        <form class="admin-login-form" method="POST" action="<?= $link->url("auth.login") ?>">

            <h1>Prihlásenie administrátora</h1>

            <?php if (!empty($message)): ?>
                <p class="login-error">
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Používateľské meno</label>
                <input type="text" id="username" name="username" placeholder="Zadajte používateľské meno" required
                    autofocus>
            </div>

            <div class="form-group">
                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" placeholder="Zadajte heslo" required>
            </div>

            <button type="submit" name="submit" value="1">Prihlásiť sa</button>

            <a href="<?= $link->url("home.index") ?>">Späť na hlavnú stránku</a>

        </form>

    </main>

</body>

</html>
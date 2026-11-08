<?php

session_start();

// Kontrola prihlásenia
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrácia | LGR</title>
</head>
<body>

    <h1>Administrácia</h1>

    <p>
        Vitaj, <?= htmlspecialchars($_SESSION['admin_username']) ?>!
    </p>

    <a href="logout.php">Odhlásiť sa</a>

</body>
</html>
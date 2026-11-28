<?php

session_start();
if (
    !isset($_SESSION['admin_id']) ||
    !in_array($_SESSION['admin_role'] ?? '', ['admin', 'dev'], true)
) {
    header('Location: ../Pages/index.php');
    exit;
}

require_once __DIR__ . '/../../databaseConections/database.php';

$sql = "select 
    id,
    first_name,
    last_name,
    email,
    phone,
    note,
    gdpr_consent,
    created_at,
    is_resolved 
    from contact order by created_at desc";

$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(); ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správy | Administrácia LGR</title>

    <link rel="stylesheet" href="../../../shared/css/global.css">
    <link rel="stylesheet" href="../../../shared/css/Admin/adminInterface.css">

    <script>
        const BASE_URL = "../../../shared/";
    </script>
</head>

<body>

    <main class="admin-messages">

        <h1>Prijaté správy</h1>

        <a href="../../Pages/index.php">Späť na hlavnú stránku</a>
        <p>Počet prijatých správ: <?= count($messages) ?></p>
        <p id="contact-message" class="form-message" hidden></p>

        <?php if (empty($messages)): ?>

            <p>Zatiaľ neboli prijaté žiadne správy.</p>

        <?php else: ?>

            <div class="form-list">

                <?php foreach ($messages as $message): ?>

                    <article class="form-card">

                        <h2>
                            <?= htmlspecialchars($message['first_name']) ?>
                            <?= htmlspecialchars($message['last_name']) ?>
                        </h2>

                        <p>
                            <strong>E-mail:</strong>
                            <?= htmlspecialchars($message['email']) ?>
                        </p>

                        <p>
                            <strong>Telefón:</strong>
                            <?= htmlspecialchars($message['phone']) ?>
                        </p>

                        <div class="form-content">
                            <strong>Správa:</strong>
                            <p><?= nl2br(htmlspecialchars($message['note'])) ?></p>
                        </div>

                        <p>
                            <strong>Dátum:</strong>
                            <?= htmlspecialchars($message['created_at']) ?>
                        </p>

                        <p>
                            <strong>GDPR súhlas:</strong>

                            <?= $message['gdpr_consent'] ? 'Áno' : 'Nie' ?>
                        </p>

                        <p class="message-status">
                            <strong>Stav:</strong>

                            <span class="<?= $message['is_resolved'] ? 'resolved' : 'unresolved' ?>">
                                <?= $message['is_resolved'] ? 'Vybavené' : 'Nevybavené' ?>
                            </span>
                        </p>

                        <form class="update-message" method="POST" action="../Admin-scripts/admin-scripts.php"
                            data-url="../Admin-scripts/admin-scripts.php">
                            <input type="hidden" name="action" value="update-message">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id" value="<?= (int) $message['id'] ?>">

                            <input type="hidden" name="is_resolved" value="<?= $message['is_resolved'] ? 0 : 1 ?>">

                            <button type="submit">
                                <?= $message['is_resolved']
                                    ? 'Vrátiť medzi nevybavené'
                                    : 'Označiť ako vybavené' ?>
                            </button>
                        </form>

                        <form class="delete-message" method="POST" action="../Admin-scripts/admin-scripts.php"
                            data-url="../Admin-scripts/admin-scripts.php">

                            <input type="hidden" name="action" value="delete-message">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id" value="<?= (int) $message['id'] ?>">

                            <button type="submit" class="delete-button">
                                Vymazať správu
                            </button>
                        </form>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </main>
    <script src="../../../shared/js/Admin-js/admin-scripts.js"></script>
</body>

</html>
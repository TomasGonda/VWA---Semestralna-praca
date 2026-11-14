<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: Admin/adminLogin.php');
    exit;
}

require_once __DIR__ . '/../databaseConections/database.php';

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

    <link rel="stylesheet" href="../../shared/css/global.css">
    <link rel="stylesheet" href="../../shared/css/Admin/adminInterface.css">
</head>

<body>

    <main class="admin-messages">

        <h1>Prijaté správy</h1>

        <a href="../Pages/index.php">Späť na hlavnú stránku</a>
        <p>Počet prijatých správ: <?= count($messages) ?></p>

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

                        <p>
                            <strong>Stav:</strong>

                            <?php if ($message['is_resolved']): ?>
                                <span class="resolved">Vybavené</span>
                            <?php else: ?>
                                <span class="unresolved">Nevybavené</span>
                            <?php endif; ?>
                        </p>

                        <form method="POST" action="Admin-scripts/updateMessage.php">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id" value="<?= (int) $message['id'] ?>">

                            <input type="hidden" name="is_resolved" value="<?= $message['is_resolved'] ? 0 : 1 ?>">

                            <button type="submit">
                                <?= $message['is_resolved']
                                    ? 'Vrátiť medzi nevybavené'
                                    : 'Označiť ako vybavené' ?>
                            </button>
                        </form>

                        <form method="POST" action="Admin-scripts/deleteMessage.php"
                            onsubmit="return confirm('Naozaj chcete vymazať túto správu?');">

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

</body>

</html>
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
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminLogin.css') ?>">

    <script>
        const BASE_URL = "";
    </script>

</head>

<body>

    <main class="admin-messages">

        <h1>Prijaté správy</h1>

        <a href="<?= $link->url("home.index") ?>">Späť na hlavnú stránku</a>
        <p>Počet prijatých správ: <?= count($messages) ?></p>
        <p id="contact-message" class="form-message" hidden></p>
        <?php if (empty($messages)): ?>

            <p>Zatiaľ neboli prijaté žiadne správy.</p>

        <?php else: ?>

            <div class="form-list">

                <?php foreach ($messages as $message): ?>

                    <article class="form-card">

                        <h2>
                            <?= htmlspecialchars($message->firstName) ?>
                            <?= htmlspecialchars($message->lastName) ?>
                        </h2>

                        <p>
                            <strong>E-mail:</strong>
                            <?= htmlspecialchars($message->email) ?>
                        </p>

                        <p>
                            <strong>Telefón:</strong>
                            <?= htmlspecialchars($message->phone ?? '') ?>
                        </p>

                        <div class="form-content">
                            <strong>Správa:</strong>
                            <p><?= nl2br(htmlspecialchars($message->note ?? '')) ?></p>
                        </div>

                        <p>
                            <strong>Dátum:</strong>
                            <?= htmlspecialchars($message->createdAt ?? '') ?>
                        </p>

                        <p>
                            <strong>GDPR súhlas:</strong>
                            <?= $message->gdprConsent ? 'Áno' : 'Nie' ?>
                        </p>

                        <p class="message-status">
                            <strong>Stav:</strong>

                            <span class="<?= $message->isResolved ? 'resolved' : 'unresolved' ?>">
                                <?= $message->isResolved ? 'Vybavené' : 'Nevybavené' ?>
                            </span>
                        </p>

                        <form class="update-message" method="POST" action="<?= $link->url('admin.updateMessage') ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id" value="<?= (int) $message->id ?>">

                            <input type="hidden" name="is_resolved" value="<?= $message->isResolved ? 0 : 1 ?>">

                            <button type="submit">
                                <?= $message->isResolved
                                    ? 'Vrátiť medzi nevybavené'
                                    : 'Označiť ako vybavené' ?>
                            </button>
                        </form>

                        <form class="delete-message" method="POST" action="<?= $link->url('admin.deleteMessage') ?>">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                            <input type="hidden" name="id" value="<?= (int) $message->id ?>">

                            <button type="submit" class="delete-button">
                                Vymazať správu
                            </button>
                        </form>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </main>
    <script src="<?= $link->asset('js/Admin-js/admin-scripts.js') ?>" defer></script>
</body>

</html>
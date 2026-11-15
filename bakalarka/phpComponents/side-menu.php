<link rel="stylesheet" href="../../shared/css/side-menu.css">

<div class="side-menu">
    <h2><?= htmlspecialchars($translations['categories'] ?? 'Kategórie') ?></h2>

    <div class="side-menu-item">
        <button type="button" class="side-menu-button">
            <?= htmlspecialchars($translations['menu_sport_tables'] ?? 'Športové tabule') ?>
            <span class="arrow">▼</span>
        </button>

        <div class="side-submenu">
            <a href=""><?= htmlspecialchars($translations['hockey'] ?? 'Hokej') ?></a>
            <a href=""><?= htmlspecialchars($translations['football'] ?? 'Futbal') ?></a>
            <a href=""><?= htmlspecialchars($translations['basketball'] ?? 'Basketbal') ?></a>
            <a href=""><?= htmlspecialchars($translations['volleyball'] ?? 'Volejbal') ?></a>
        </div>
    </div>
</div>

<script src="../../shared/js/side-menu.js" defer></script>
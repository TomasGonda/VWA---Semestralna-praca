<?php
//var_dump($language);
//var_dump($translations);
?>
<?php if (isset($_SESSION['admin_id'])): ?>
    <section class="admin-panel">
        <h2>Administrácia</h2>

        <div class="admin-controls">
            <a href="">Správa produktov</a>
            <a href="Admin/adminFormular.php">Správy z formulára</a>
            <a href="">Správa prekladov</a>
            <a href="Admin/logout.php">Odhlásiť sa</a>
        </div>
    </section>

<?php endif; ?>

<div class="top-section">
    <div class="top-menu">
        <div class="top-menu-inner">
            <span>
                <?= htmlspecialchars($translations['title'] ?? 'Športové výsledkové tabule') ?>
            </span>

            <nav class="top-links">
                <a href="aboutUs.php">
                    <?= htmlspecialchars($translations['about'] ?? 'O nás') ?>
                </a>

                <a href="contact.php">
                    <?= htmlspecialchars($translations['contact'] ?? 'Kontakt') ?>
                </a>

                <div class="language-switch">
                    <button class="language-button" type="button" aria-expanded="false">
                        <?php if ($language === 'sk'): ?>
                            <img src="../shared/imgs/Flag_of_Slovakia.png" alt="">
                            <span>SK</span>
                        <?php else: ?>
                            <img src="../shared/imgs/england.png" alt="">
                            <span>EN</span>
                        <?php endif; ?>

                        <span class="arrow">▼</span>
                    </button>

                    <div class="language-dropdown">
                        <a href="?lang=sk">
                            <img src="../shared/imgs/Flag_of_Slovakia.png" alt="">
                            <?= htmlspecialchars($translations['slovak_language'] ?? 'Slovenčina') ?>
                        </a>

                        <a href="?lang=en">
                            <img src="../shared/imgs/england.png" alt="">
                            <?= htmlspecialchars($translations['english_language'] ?? 'English') ?>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <header class="top-header">
        <a href="index.php" class="logo-link">
            <img class="header-img" src="../shared/imgs/Logo_cele.png" alt="LGR - domovská stránka">
        </a>

        <form class="search-form" action="" method="get">
            <input type="search" name="q"
                placeholder="<?= htmlspecialchars($translations['search_placeholder'] ?? 'Vyhľadávanie') ?>"
                aria-label="Vyhľadávanie produktov">

            <button type="submit" aria-label="Hľadať">
                <?= htmlspecialchars($translations['search'] ?? 'Hľadať') ?>
            </button>
        </form>

        <div class="header-actions">
            <a href="">
                <?= htmlspecialchars($translations['cart'] ?? 'Košík') ?>
            </a>
        </div>
    </header>

    <div class="main-menu">
        <nav class="nav-bar" aria-label="Hlavná navigácia">

            <a href="">
                <?= htmlspecialchars($translations['menu_sport_tables'] ?? 'Športové tabule') ?>
            </a>

            <a href="">
                <?= htmlspecialchars($translations['menu_stop_watch'] ?? 'Stopky') ?>
            </a>

            <a href="">
                <?= htmlspecialchars($translations['menu_basketball'] ?? 'Basketball') ?>
            </a>

            <a href="">
                <?= htmlspecialchars($translations['menu_utilities'] ?? 'Príslušenstvo') ?>
            </a>

        </nav>
    </div>
</div>
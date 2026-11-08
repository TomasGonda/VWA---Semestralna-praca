<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $link->asset('favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $link->asset('favicons/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>
        const BASE_URL = <?= json_encode($link->asset('../../shared/')) ?>;
    </script>
    <script src="<?= $link->asset('../../shared/js/script.js') ?>" defer></script>

    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/top-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/top-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/main-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/main-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('../../shared/css/adminLogin.css') ?>">
</head>

<?php if (isset($_SESSION['admin_id'])): ?>
    <section class="admin-panel">
        <h2>Administrácia</h2>

        <div class="admin-controls">
            <a href="">Správa produktov</a>
            <a href="<?= $link->url("admin.adminFormular") ?>">Správy z formulára</a>
            <a href="">Správa prekladov</a>
            <a href="<?= $link->url("admin.logout") ?>">Odhlásiť sa</a>
        </div>
    </section>

<?php endif; ?>

<body>
    <div class="top-section">
        <div class="top-menu">
            <div class="top-menu-inner">
                <span><?= htmlspecialchars($translations['title'] ?? "Športové výsledkové tabule", ENT_QUOTES, "UTF-8") ?></span>

                <nav class="top-links">
                    <a href="<?= $link->url("admin.adminLogin") ?>">
                        <?= htmlspecialchars($translations['about'] ?? "O Nás", ENT_QUOTES, "UTF-8") ?>
                    </a>

                    <a href="<?= $link->url("home.contact") ?>">
                        <?= htmlspecialchars($translations['contact'] ?? "Kontakt", ENT_QUOTES, "UTF-8") ?>
                    </a>
                    <div class="language-switch">
                        <button class="language-button" type="button" aria-expanded="false">
                            <?php if ($currentLanguage === 'sk'): ?>
                                <img src="<?= $link->asset('../../shared/imgs/Flag_of_Slovakia.png') ?>" alt="">
                                <span>SK</span>
                            <?php elseif ($currentLanguage === 'en'): ?>
                                <img src="<?= $link->asset('../../shared/imgs/england.png') ?>" alt="">
                                <span>EN</span>
                            <?php endif; ?>
                            <span class="arrow">▼</span>
                        </button>

                        <div class="language-dropdown">
                            <a href="?lang=sk">
                                <img src="<?= $link->asset('../../shared/imgs/Flag_of_Slovakia.png') ?>" alt="">
                                Slovenčina
                            </a>

                            <a href="?lang=en">
                                <img src="<?= $link->asset('../../shared/imgs/england.png') ?>" alt=""> English
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <header class="top-header">
            <a href="<?= $link->url('home.index') ?>" class="logo-link">
                <img class="header-img" src="<?= $link->asset('../../shared/imgs/Logo_cele.png') ?>"
                    alt="LGR - domovská stránka">
            </a>

            <form class="search-form" action="" method="get">
                <input type="search" name="q" placeholder=<?= htmlspecialchars($translations['search_placeholder'] ?? "Vyhľadávanie", ENT_QUOTES, "UTF-8") ?> aria-label="Vyhľadávanie produktov">

                <button type="submit" aria-label="Hľadať"> <?= htmlspecialchars($translations['search'] ?? "Hľadať", ENT_QUOTES, "UTF-8") ?></button>
            </form>

            <div class="header-actions">
                <a href=""><?= htmlspecialchars($translations['cart'] ?? "Košík", ENT_QUOTES, "UTF-8") ?></a>
            </div>
        </header>

        <div class="main-menu">
            <nav class="nav-bar" aria-label="Hlavná navigácia">

                <a href=""><?= htmlspecialchars($translations['menu_sport_tables'] ?? "Športové tabule", ENT_QUOTES, "UTF-8") ?></a>
                <a href=""><?= htmlspecialchars($translations['menu_stop_watch'] ?? "Stopky", ENT_QUOTES, "UTF-8") ?></a>
                <a href=""><?= htmlspecialchars($translations['menu_basketball'] ?? "Basketball", ENT_QUOTES, "UTF-8") ?></a>
                <a href=""><?= htmlspecialchars($translations['menu_utilities'] ?? "Príslušenstvo", ENT_QUOTES, "UTF-8") ?></a>
            </nav>
        </div>
    </div>

    <main>
        <?= $contentHTML ?>
    </main>

    <footer>
        //footer
    </footer>
</body>

</html>
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
    const BASE_URL = <?= json_encode($link->asset('')) ?>;
    </script>
    <script src="<?= $link->asset('js/scripts.js') ?>" defer></script>
    
    <link rel="stylesheet" href="<?= $link->asset('css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-responsivity.css') ?>">
</head>
<body>
<div class="top-section">
            <div class="top-menu">
                <div class="top-menu-inner">
                    <span>Športové výsledkové tabule</span>

                    <nav class="top-links">
                        <a href="">O nás</a>
                        <a href="">Kontakt</a>
                        <div class="language-switch">
                            <button class="language-button" type="button" aria-expanded="false">
                                <img src="<?= $link->asset('images/Flag_of_Slovakia.png') ?>" alt="">
                                <span>SK</span>
                                <span class="arrow">▼</span>
                            </button>

                            <div class="language-dropdown">
                                <a href="?lang=sk">
                                    <img src="<?= $link->asset('images/Flag_of_Slovakia.png') ?>" alt=""> Slovenčina
                                </a>

                                <a href="?lang=en">
                                    <img src="<?= $link->asset('images/england.png') ?>" alt=""> English
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <header class="top-header">
                <a href="<?= $link->url('home.index') ?>" class="logo-link">
                    <img class="header-img" src="<?= $link->asset('images/Logo_cele.png') ?>" alt="LGR - domovská stránka">
                </a>

                <form class="search-form" action="" method="get">
                    <input type="search" name="q" placeholder="Vyhľadávanie" aria-label="Vyhľadávanie produktov">

                    <button type="submit" aria-label="Hľadať"> Hľadať</button>
                </form>

                <div class="header-actions">
                    <a href="">Košík</a>
                </div>
            </header>

        <div class="main-menu">
            <nav class="nav-bar" aria-label="Hlavná navigácia">

                <a href="">Športové tabule</a>
                <a href="">Stopky</a>
                <a href="">Basketball</a>
                <a href="">Príslušenstvo</a>
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

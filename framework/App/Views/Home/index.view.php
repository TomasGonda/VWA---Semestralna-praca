<?php

/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'LGR' ?></title>

    <link rel="stylesheet" href="<?= $link->asset('css/global.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/top-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-section.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/main-responsivity.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/Admin/adminLogin.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/side-menu.css') ?>">
</head>

<body>
    <main>
        <div class="main-columns-home">
            <div class="main-left-home">
                <div class="carousel-img">
                    <img id="carousel-img" src= "<?= $link->asset('imgs/o2arena1-700x400.jpg')?>" alt="Hokejbal">

                    <button class="carousel-arrow prev" id="prev-image" type="button"
                        aria-label="Predchádzajúci obrázok">&#10094;</button>

                    <button class="carousel-arrow next" id="next-image" type="button"
                        aria-label="Nasledujúci obrázok">&#10095;</button>
                </div>
            </div>

            <div class="main-right-home">
                <div class="side-menu">
                    <h2>
                        <?= htmlspecialchars($translations['categories'] ?? 'Kategórie') ?>
                    </h2>

                    <div class="side-menu-item">
                        <button type="button" class="side-menu-button">
                            <?= htmlspecialchars($translations['menu_sport_tables'] ?? 'Športové tabule') ?>
                            <span class="arrow">▼</span>
                        </button>

                        <div class="side-submenu">
                            <a href="">
                                <?= htmlspecialchars($translations['hockey'] ?? 'Hokej') ?>
                            </a>
                            <a href="">
                                <?= htmlspecialchars($translations['football'] ?? 'Futbal') ?>
                            </a>
                            <a href="">
                                <?= htmlspecialchars($translations['basketball'] ?? 'Basketbal') ?>
                            </a>
                            <a href="">
                                <?= htmlspecialchars($translations['volleyball'] ?? 'Volejbal') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script src="<?= $link->asset('js/script.js') ?>" defer></script>
    <script src="<?= $link->asset('js/side-menu.js') ?>" defer></script>
</body>
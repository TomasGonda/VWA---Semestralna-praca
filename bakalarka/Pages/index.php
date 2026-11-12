<?php
require_once __DIR__ . '/../phpComponents/database_ini.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavná stránka</title>
    <link rel="stylesheet" href="../../shared/css/global.css">
    <link rel="stylesheet" href="../../shared/css/main-section.css">
    <link rel="stylesheet" href="../../shared/css/main-responsivity.css">
    <link rel="stylesheet" href="../../shared/css/side-menu.css">

    <script>
        const BASE_URL = "../../shared/";
    </script>
    <script src="../../shared/js/script.js" defer></script>

</head>

<body>
    <?php require_once __DIR__ . '/../phpComponents/top-section.php'; ?>
    <main>
        <div class="main-columns-home">
            <div class="main-left-home">
                <div class="carousel-img">
                    <img id="carousel-img" src="../../shared/imgs/o2arena1-700x400.jpg" alt="Hokejbal">

                    <button class="carousel-arrow prev" id="prev-image" type="button"
                        aria-label="Predchádzajúci obrázok">&#10094;</button>

                    <button class="carousel-arrow next" id="next-image" type="button"
                        aria-label="Nasledujúci obrázok">&#10095;</button>
                </div>
            </div>

            <div class="main-right-home">
                <?php require_once __DIR__ . '/../phpComponents/side-menu.php'; ?>
            </div>

        </div>

    </main>

</body>
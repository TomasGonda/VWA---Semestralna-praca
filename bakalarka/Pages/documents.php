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

    <script>
        const BASE_URL = "../../shared/";
    </script>
    <script src="../../shared/js/script.js" defer></script>

</head>

<body>
    <?php require_once __DIR__ . '/../phpComponents/top-section.php'; ?>
    <main>
        <div class="main-columns">

            <div class="main-left">

            </div>

            <div class="main-right">
                <?php require_once __DIR__ . '/../phpComponents/side-menu.php'; ?>
            </div>

        </div>

    </main>

</body>
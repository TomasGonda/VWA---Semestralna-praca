<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavná stránka</title>
    <link rel="stylesheet" href="../shared/css/global.css">
    <link rel="stylesheet" href="../shared/css/top-section.css">
    <link rel="stylesheet" href="../shared/css/top-responsivity.css">
    <link rel="stylesheet" href="../shared/css/main-section.css">
    <link rel="stylesheet" href="../shared/css/main-responsivity.css">

    <script>
        const BASE_URL = "../shared/";
    </script>
    <script src="../shared/js/script.js" defer></script>

</head>

<body>
    <?php require_once __DIR__ . '/php/top-section.php'; ?>
    <main>
        <div class="carousel-img">
            <img id="carousel-img" src="../shared/imgs/hokejbal-170T-1-700x400.jpg" alt="Hokejball">

            <button class="carousel-arrow prev" id="prev-image" type="button"
                aria-label="Predchádzajúci obrázok">&#10094
            </button>

            <button class="carousel-arrow next" id="next-image" type="button" aria-label="Nasledujúci obrázok">&#10095
            </button>
        </div>

    </main>

</body>
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
    <link rel="stylesheet" href="<?= $link->asset('css/adminInterface.css') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/adminLogin.css') ?>">
</head>

<body>
    <div class="carousel-img">
    <img id="carousel-img" src="<?= $link->asset('imgs/hokejbal-170T-1-700x400.jpg') ?>" alt="Hokejball">

    <button class="carousel-arrow prev" id="prev-image" type="button" aria-label="Predchádzajúci obrázok">&#10094
    </button>

    <button class="carousel-arrow next" id="next-image" type="button" aria-label="Nasledujúci obrázok">&#10095
    </button>
</div>
</body>
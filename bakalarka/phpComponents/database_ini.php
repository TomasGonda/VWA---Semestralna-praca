<?php

session_start();

require_once __DIR__ . '/../databaseConections/database.php';
require_once __DIR__ . '/../Models/LanguageModel.php';

$availableLanguages = ['sk', 'en'];

if (isset($_GET['lang']) && in_array($_GET['lang'], $availableLanguages, true)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$language = $_SESSION['lang'] ?? 'sk';

$languageModel = new LanguageModel($pdo);
$translations = $languageModel->getTranslations($language);

?>
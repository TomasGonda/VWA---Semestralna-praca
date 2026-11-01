<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../Framework/ClassLoader.php';

use Framework\Core\App;

$app = new App();
$app->run();



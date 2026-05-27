<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/Model.php';
require_once __DIR__ . '/app/Core/Controller.php';
require_once __DIR__ . '/app/Core/App.php';

$app = new App();
$app->run();

<?php
require_once 'functions.php';
session_start();

$action = $_GET['action'] ?? 'home';

$routes = [
    'home' => function() { include 'views/home.php'; },
    'prenota' => function() { require_once 'controllers/PrenotazioneController.php'; PrenotazioneController::prenota(); },
    'verifica' => function() { require_once 'controllers/PrenotazioneController.php'; PrenotazioneController::verifica(); },
    'login' => function() { require_once 'controllers/AuthController.php'; AuthController::login(); },
    'logout' => function() { require_once 'controllers/AuthController.php'; AuthController::logout(); },
    'dashboard' => function() { require_once 'controllers/DashboardController.php'; DashboardController::dashboard(); },
    'azione' => function() { require_once 'controllers/PrenotazioneController.php'; PrenotazioneController::azione(); },
    'export' => function() { require_once 'controllers/DashboardController.php'; DashboardController::export(); },
];

if (isset($routes[$action])) {
    $routes[$action]();
} else {
    include 'views/home.php';
}
?>

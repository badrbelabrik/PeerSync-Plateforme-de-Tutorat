<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nouvel autoloader adapté à tes namespaces sans le préfixe "App"
spl_autoload_register(function ($class) {
    // On remplace les anti-slashs (\) du namespace par des slashs (/) pour le chemin système
    $classPath = str_replace('\\', '/', $class);

    // Ton dossier racine pour le code est "src"
    $file = __DIR__ . '/src/' . $classPath . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// À la ligne 40, appelle ton contrôleur avec son namespace exact :
use Controllers\AuthController;

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        $authController = new AuthController(); // Plus d'erreur ici !
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            require_once __DIR__ . '/views/login.php';
        }
        break;

    // ... reste de ton switch ...
}
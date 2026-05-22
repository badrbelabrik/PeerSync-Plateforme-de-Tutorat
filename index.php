<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// L'autoloader magique
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    $file = __DIR__ . '/src/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Controllers\AuthController;
use Repositories\UserRepository;
use Repositories\SkillRepository;

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        // 🌟 SÉCURITÉ INVERSÉE : Si l'utilisateur est déjà connecté en session,
        // on lui interdit l'accès au login et on le renvoie vers le dashboard.
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?route=dashboard');
            exit();
        }

        $authController = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            require_once __DIR__ . '/views/login.php';
        }
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit();
        }

        // On récupère l'user ici pour la vue
        $userRepo = new UserRepository();

        $currentUser = $userRepo->getUserById((int)$_SESSION['user_id']);

        $helpRepo = new \Repositories\HelpRequestRepository();
        $skillsRepo = new \Repositories\SkillRepository();
        $activeRequests = $helpRepo->getActiveRequests();
        $resolvedRequests = $helpRepo->getResolvedRequests();
        $skills = $skillsRepo->getAllSkills();
        if (!$currentUser) {
            session_destroy();
            header('Location: views/student-dashboard.php');
            exit();
        }

        require_once __DIR__ . '/views/student-dashboard.php';
        break;
    case 'create-ticket':
        $helpController = new \Controllers\HelpRequestController();
        $helpController->create();
        break;
    case 'accept-ticket':
        $helpController = new \Controllers\HelpRequestController();
        $helpController->accept();
        break;

    case 'my-requests':
        $helpController = new \Controllers\HelpRequestController();
        $helpController->myRequests();
        break;

    case 'resolve-ticket':
        $helpController = new \Controllers\HelpRequestController();
        $helpController->resolve();
        break;

    default:
        http_response_code(404);
        echo "<h1>Page 404 non trouvée</h1>";
        break;
}
<?php

namespace Controllers;

use Repositories\UserRepository;

class AuthController
{
    private UserRepository $userRepo;

    public function __construct(){
        $this->userRepo = new UserRepository();
    }

    public function login():void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
                require_once __DIR__ . '/../../views/login.php';
                return;
            }


            $user = $this->userRepo->verifyLogin($email,$password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_firstname'] = $user->getFirstname();
                $_SESSION['user_role'] = $user->getRole();

                header('Location: index.php?route=dashboard');
                exit();
            } else {
                $error = "Identifiants incorrects.";
                require_once __DIR__ . '/../../views/login.php';
            }
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
<?php

namespace Controllers;

use Entities\HelpRequest;
use Entities\Skill;
use Exception;
use Repositories\HelpRequestRepository;
use Repositories\UserRepository;

class HelpRequestController
{
    private HelpRequestRepository $helpRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->helpRepo = new HelpRequestRepository();
        $this->userRepo = new UserRepository();
    }

    public function create(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $skill = isset($_POST['skill']) ? trim(htmlspecialchars($_POST['skill'])) : '';
            $learnerId = (int)$_SESSION['user_id'];
        }
        if (empty($title) || empty($description)) {
            header('Location: index.php?route=dashboard');
            exit();
        }
        $newLearner = $this->userRepo->getUserById($learnerId);
        $newSkill = new Skill($skill);
        $newHelp = new HelpRequest($title,$description,$newLearner,$newSkill);
        $success = $this->helpRepo->create($newHelp);
        header('Location: index.php?route=dashboard');
        exit();
    }

    public function accept(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit();
        }

        $ticketId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($ticketId > 0) {
            try {
                $tutor = $this->userRepo->getUserById((int)$_SESSION['user_id']);

                $helpRequest = $this->helpRepo->getHelpById($ticketId);

                var_dump($helpRequest->getId(), $helpRequest->getStatus());
                die();
                if ($helpRequest && $tutor) {
                    $helpRequest->assignTo($tutor);

                    $this->helpRepo->updateAssignment($helpRequest);
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }

        header('Location: index.php?route=dashboard');
        exit();
    }
}
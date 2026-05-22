<?php

namespace Controllers;

use Entities\HelpRequest;
use Entities\Skill;
use Exception;
use Repositories\HelpRequestRepository;
use Repositories\SkillRepository;
use Repositories\UserRepository;

class HelpRequestController
{
    private HelpRequestRepository $helpRepo;
    private UserRepository $userRepo;
    private SkillRepository $skillRepo;

    public function __construct()
    {
        $this->helpRepo = new HelpRequestRepository();
        $this->userRepo = new UserRepository();
        $this->skillRepo = new SkillRepository();
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
        $newSkill = $this->skillRepo->findSkillByName($skill);
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

    public function resolve(){
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
                $helpRequest = $this->helpRepo->getHelpById($ticketId);

                if ($helpRequest) {
                    $this->helpRepo->markAsResolved($helpRequest);
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }
        header('Location: index.php?route=dashboard');
        exit();
    }

    public function myRequests(): void
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit();
        }

        $userId = (int)$_SESSION['user_id'];

        $currentUser = $this->userRepo->getUserById($userId);

        $myRequests = $this->helpRepo->getRequestsByUserId($userId);
        $skillsRepo = new \Repositories\SkillRepository();
        $userSkills = $skillsRepo->getSkillsByUserId($userId);
        require_once __DIR__ . '/../../views/my-requests.php';
    }
}
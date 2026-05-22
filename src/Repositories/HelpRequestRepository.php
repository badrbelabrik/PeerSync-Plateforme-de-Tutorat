<?php

namespace Repositories;
use Entities\HelpRequest;
use Entities\Skill;
use Entities\User;
use PDO;
use PDOException;
use Config\Database;

class HelpRequestRepository
{
    private PDO $pdo;
    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function create(HelpRequest $helpReq):bool{
        try{
            $sql = "INSERT INTO help_requests(title,description,id_learner,id_skill) VALUES(?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
             $success = $stmt->execute([
                $helpReq->getTitle(),
                $helpReq->getDescription(),
                $helpReq->getLearner()->getId(),
                 $helpReq->getSkill()->getId()
            ]);
             if($success){
                 $helpReq->setId((int)$this->pdo->lastInsertId());
                 return true;
             }
             return false;
        } catch(PDOException $e){
            echo "Error: ".$e->getMessage();
            return false;
        }
    }

    public function getResolvedRequests():array{
        try{
            $sql = "SELECT hr.*, u.firstname, u.lastname 
                    FROM help_requests hr
                    INNER JOIN users u ON hr.id_learner = u.id
                    WHERE hr.status = 'resolved'
                    ORDER BY hr.created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return [];
        }
    }
    public function getActiveRequests():array{
        try{
            $sql = "SELECT hr.*, u.firstname, u.lastname 
                    FROM help_requests hr
                    INNER JOIN users u ON hr.id_learner = u.id
                    WHERE hr.status = 'pending' OR hr.status = 'assigned'
                    ORDER BY hr.created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return [];
        }
    }

    public function updateAssignment(HelpRequest $helpReq):void{
        try{
            $sql = "UPDATE help_requests SET status = ?, id_tutor = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $helpReq->getStatus(),
                $helpReq->getTutor()->getId(),
                $helpReq->getId()
            ]);
        } catch(PDOException $e){
            echo "Error :".$e->getMessage();
        }
    }

    public function getHelpById(int $id): ?HelpRequest
    {
        try {
            $sql = "SELECT hr.*, 
                       u.id AS user_id, 
                       u.firstname AS user_firstname, 
                       u.lastname AS user_lastname,
                       u.id_role AS user_role
                FROM help_requests hr
                INNER JOIN users u ON hr.id_learner = u.id
                WHERE hr.id = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }
            $student = new \Entities\User(
                $row['user_firstname'] ?? '',
                $row['user_lastname'] ?? '',
                $row['email'] ?? '',
                $row['user_id_role'] ?? 'student',
                (int)($row['points'] ?? 0),
                (int)$row['user_id']
            );

            $skill = new \Entities\Skill($row['skill_label'] ?? '');

            return $helpRequest = new \Entities\HelpRequest(
                $row['title'],
                $row['description'],
                $student,
                $skill,
                $row['status'] ?? 'pending',
                null,
                (int)$row['id']
            );


        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage();
            return null;
        }
    }

    public function markAsResolved(HelpRequest $helpReq){
        try{
            $sql = "UPDATE help_requests SET status = 'resolved' WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$helpReq->getId()]);
        }catch(PDOException $e){
            echo "Error :".$e->getMessage();
        }
    }

    public function getRequestsByUserId(int $userId): array
    {
        try {
            $sql = "SELECT hr.*, 
                       u.firstname, u.lastname,
                       t.firstname AS tutor_firstname, t.lastname AS tutor_lastname
                FROM help_requests hr
                INNER JOIN users u ON hr.id_learner = u.id
                LEFT JOIN users t ON hr.id_tutor = t.id
                WHERE hr.id_learner = :user_id OR hr.id_tutor = :user_id
                ORDER BY hr.created_at DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error : " . $e->getMessage();
            return [];
        }
    }

}
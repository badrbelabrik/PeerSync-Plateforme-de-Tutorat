<?php

namespace Repositories;
use Entities\HelpRequest;
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
            $sql = "INSERT INTO help_requests(title,description,id_learner) VALUES(?,?,?)";
            $stmt = $this->pdo->prepare($sql);
             $success = $stmt->execute([
                $helpReq->getTitle(),
                $helpReq->getDescription(),
                $helpReq->getLearner()->getId()
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

    public function getResolvedRequests():?array{
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
            return null;
        }
    }
    public function getActiveRequests():?array{
        try{
            $sql = "SELECT hr.*, u.firstname, u.lastname 
                    FROM help_requests hr
                    INNER JOIN users u ON hr.id_learner = u.id
                    WHERE hr.status = 'pending'
                    ORDER BY hr.created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return null;
        }
    }

}
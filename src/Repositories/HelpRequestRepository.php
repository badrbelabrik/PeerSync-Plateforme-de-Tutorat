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

}
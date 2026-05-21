<?php

namespace Repositories;

use Config\Database;
use Entities\Skill;
use PDO;
use PDOException;

class SkillRepository
{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function findSkillByName(string $skill):?Skill{
        try{
            $sql = "SELECT * FROM skills WHERE name = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$skill]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$result){
                return null;
            }
            return new Skill(
                $result->name,
                $result->id
            );
        } catch(PDOException $e){
            echo "Error:".$e->getMessage();
            return null;
        }

    }
}
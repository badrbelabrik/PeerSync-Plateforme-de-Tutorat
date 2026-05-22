<?php

namespace Repositories;

use Entities\Skill;
use PDO;
use PDOException;
use Config\Database;

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

    public function findSkillById($id){
        try{
            $sql = "SELECT * FROM skills WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
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

    public function getAllSkills():?array{
        try{
            $sql = "SELECT * FROM skills";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return null;
        }
    }
}
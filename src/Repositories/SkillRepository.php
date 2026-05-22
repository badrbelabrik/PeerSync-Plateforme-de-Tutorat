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

    public function getAllSkills():array{
        try{
            $sql = "SELECT * FROM skills";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return [];
        }
    }

    public function getSkillsByUserId($userId):array{
        try{
            $sql = "SELECT u.firstname,u.lastname,s.name AS skill_name,us.level AS skill_level FROM users u
                    JOIN user_skills us ON us.id_user = u.id
                    JOIN skills s ON s.id = us.id_skill
                    WHERE u.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $result = $stmt->fetchAll(PDO::FETCH_ASSOC)?: [];
        }catch(PDOException $e){
            echo "Error :".$e->getMessage();
            return [];
        }
}
}
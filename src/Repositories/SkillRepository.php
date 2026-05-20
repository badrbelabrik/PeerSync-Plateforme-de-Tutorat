<?php

namespace Repositories;

use Config\Database;
use Entities\Skill;
use PDO;

class SkillRepository
{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function findSkillByName(string $skill):?Skill{
        $sql = "SELECT * FROM skills WHERE name = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$skill]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if($result == null){
            echo "No skill found with this name!";
        }
        return new Skill(
            $result->name,
            $result->id
        );
    }
}
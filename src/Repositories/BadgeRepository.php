<?php

namespace Repositories;

use Entities\Badge;
use PDO;
use PDOException;
use Config\Database;

class BadgeRepository
{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function findBadgeByName(string $badge):?Badge{
        try{
            $sql = "SELECT * FROM badges WHERE name = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$badge]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$result){
                return null;
            }
            return new Badge(
                $result->name,
                $result->description,
                $result->id
            );
        } catch(PDOException $e){
            echo "Error:".$e->getMessage();
            return null;
        }
    }
}
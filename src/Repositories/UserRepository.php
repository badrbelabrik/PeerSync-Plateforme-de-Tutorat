<?php

namespace Repositories;
use config\Database;
use Entities\User;
use PDO;
use PDOException;

class UserRepository
{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function getUserById(int $id):?User{
        try{
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$user){
                return null;
            }
            return new User(
                $user->firstname,
                $user->lastname,
                $user->email,
                $user->id_role,
                (int)($user->points ?? 0),
                $user->id
            );
        } catch(PDOException $e){
            echo "Error:".$e->getMessage();
            return null;
        }

    }

    public function getUserByEmail(string $email):?User{
        try{
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if($user == null){
                echo "User with this email not found!";
            }
            return new User(
                $user->firstname,
                $user->lastname,
                $user->email,
                $user->id_role,
                (int)($user->points ?? 0),
                $user->id
            );
        } catch(PDOException $e){
                echo "Error:".$e->getMessage();
                return null;
            }
        }
}
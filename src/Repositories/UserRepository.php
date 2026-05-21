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
            $user = $stmt->fetch();
            if(!$user){
                return null;
            }
            return new User(
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['label_role'] ?? 'student',
                (int)($user['points'] ?? 0),
                (int)$user['id']
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
            $user = $stmt->fetch();
            if($user == null){
                echo "User with this email not found!";
                return null;
            }
            return new User(
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['label_role'] ?? 'student',
                (int)($user['points'] ?? 0),
                (int)$user['id']
            );
        } catch(PDOException $e){
                echo "Error:".$e->getMessage();
                return null;
            }
        }

public function verifyLogin($email,$password):?User{
        try{
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $userData = $stmt->fetch();

            if(!$userData){
                return null;
            }

            if(password_verify($password,$userData['password'])){
                return new User(
                    $userData['firstname'],
                    $userData['lastname'],
                    $userData['email'],
                    $userData['label_role'] ?? 'student',
                    (int)($userData['points'] ?? 0),
                    (int)$userData['id']
                );
            }
            return null;
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
            return null;
        }
}
}
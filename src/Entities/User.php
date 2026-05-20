<?php

namespace Entities;
class User
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $role;
    private ?int $points;

    public function __construct(string $firstname,string $lastname,string $email,string $role,int $points = 0,?int $id = null){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->role = $role;
        $this->points = $points;
        $this->id = $id;
    }
}
<?php

namespace Entities;

class UserBadge
{
    private ?int $id;
    private string $date;
    private User $user;
    private Badge $badge;

    public function __construct(string $date,User $user,Badge $badge,?int $id = null){
        $this->date = $date;
        $this->user = $user;
        $this->badge = $badge;
        $this->id = $id;
    }
}
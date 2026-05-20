<?php

namespace Entities;

class UserSkill
{
    private ?int $id;
    private string $level;
    private User $user;
    private Skill $skill;

    public function __construct(string $level,User $user,Skill $skill,?int $id = null){
        $this->level = $level;
        $this->user = $user;
        $this->skill = $skill;
        $this->id = $id;
    }
}
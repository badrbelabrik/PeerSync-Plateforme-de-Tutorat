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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function setLevel(string $level): void
    {
        $this->level = $level;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): void
    {
        $this->skill = $skill;
    }
}
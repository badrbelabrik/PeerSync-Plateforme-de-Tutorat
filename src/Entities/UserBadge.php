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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getBadge(): Badge
    {
        return $this->badge;
    }

    public function setBadge(Badge $badge): void
    {
        $this->badge = $badge;
    }
}
<?php

namespace Entities;
use Exception;

class HelpRequest
{
    private ?int $id;
    private string $title;
    private string $description;
    private ?string $status;
    private User $learner;
    private Skill $skill;
    private ?User $tutor;
    private ?string $created_at;

    public function __construct(string $title,string $description,User $learner,Skill $skill,?string $status = 'pending',?User $tutor = null,?int $id = null,?string $created_at = null){
        $this->title = $title;
        $this->description = $description;
        $this->learner = $learner;
        $this->skill = $skill;
        $this->status = $status;
        $this->tutor = $tutor;
        $this->id = $id;
        $this->created_at = $created_at;
    }

    public function assignTo(User $tutor):void{
        if($tutor->getId() === $this->learner->getId()){
            throw new Exception("Erreur : Vous ne pouvez pas accepter votre propre demande d'aide.");
        }
        $this->tutor = $tutor;
        $this->status = 'assigned';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): void
    {
        $this->skill = $skill;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getLearner(): User
    {
        return $this->learner;
    }

    public function setLearner(User $learner): void
    {
        $this->learner = $learner;
    }

    public function getTutor(): ?User
    {
        return $this->tutor;
    }

    public function setTutor(?User $tutor): void
    {
        $this->tutor = $tutor;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
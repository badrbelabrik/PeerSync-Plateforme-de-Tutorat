<?php

namespace Entities;
class HelpRequest
{
    private ?int $id;
    private string $title;
    private string $description;
    private string $status;
    private User $learner;
    private ?User $tutor;
    private ?string $created_at;

    public function __construct(string $title,string $description,string $status,User $learner,?User $tutor = null,?int $id = null,?string $created_at = null){
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->learner = $learner;
        $this->tutor = $tutor;
        $this->id = $id;
        $this->created_at = $created_at;
    }
}
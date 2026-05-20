<?php

namespace Entities;
class Review
{
    private ?int $id;
    private string $comment;
    private HelpRequest $helpRequest;
    private ?string $created_at;

    public function __construct(string $comment,HelpRequest $helpRequest,?string $created_at = null,?int $id = null){
        $this->comment = $comment;
        $this->helpRequest = $helpRequest;
        $this->created_at = $created_at;
        $this->id = $id;
    }
}
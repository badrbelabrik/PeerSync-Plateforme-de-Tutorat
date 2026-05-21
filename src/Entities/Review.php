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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getHelpRequest(): HelpRequest
    {
        return $this->helpRequest;
    }

    public function setHelpRequest(HelpRequest $helpRequest): void
    {
        $this->helpRequest = $helpRequest;
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
<?php

namespace Entities;
class Badge
{
    private ?int $id;
    private string $name;
    private string $description;

    public function __construct(string $name,string $description,?int $id = null){
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
    }
}
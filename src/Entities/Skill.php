<?php

namespace Entities;
class Skill
{
    private ?int $id;
    private string $name;

    public function __construct(string $name,?int $id = null){
        $this->name = $name;
        $this->id = $id;
    }
}
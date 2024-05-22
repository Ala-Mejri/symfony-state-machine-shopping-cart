<?php

declare(strict_types=1);

namespace App\Shared\Domain\Primitive\Entity;

abstract class Entity
{
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
<?php

declare(strict_types=1);

namespace App\Shared\Domain\Primitive\Entity;

use DateTimeInterface;

interface HasTimestampsInterface
{
    public function getCreatedAt(): ?DateTimeInterface;

    public function setCreatedAt(DateTimeInterface $createdAt): static;

    public function getUpdatedAt(): ?DateTimeInterface;

    public function setUpdatedAt(DateTimeInterface $updatedAt): static;
}
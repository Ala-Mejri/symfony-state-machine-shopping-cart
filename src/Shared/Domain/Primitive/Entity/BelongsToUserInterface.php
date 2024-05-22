<?php

declare(strict_types=1);

namespace App\Shared\Domain\Primitive\Entity;

use App\Core\Domain\User\Entity\User;

interface BelongsToUserInterface
{
    public function getUser(): ?User;

    public function setUser(?User $user): static;
}
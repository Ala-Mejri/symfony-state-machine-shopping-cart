<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Entity;

use App\Core\Domain\DeliveryAddress\Entity\DeliveryAddress;
use App\Shared\Domain\Primitive\Entity\BelongsToUserInterface;

class UserDeliveryAddress extends DeliveryAddress implements BelongsToUserInterface
{
    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

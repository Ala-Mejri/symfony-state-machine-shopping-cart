<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Core\Domain\User\Entity\User;
use App\Shared\Domain\Primitive\Entity\BelongsToUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CurrentUserService
{
    public function __construct(readonly private TokenStorageInterface $usageTrackingTokenStorage)
    {
    }

    public function getUser(): ?User
    {
        return $this->usageTrackingTokenStorage->getToken()?->getUser();
    }

    public function isOwner(BelongsToUserInterface $entity): bool
    {
        return $this->getUser()?->getId() === $entity->getUser()->getId();
    }
}
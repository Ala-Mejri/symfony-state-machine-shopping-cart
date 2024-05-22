<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\User\Persistence\Doctrine\EventListener;

use App\Core\Domain\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
final class UserCreatedEventListener
{
    public function prePersist(User $user, PrePersistEventArgs $event): void
    {
        $user->onPrePersist();
    }
}
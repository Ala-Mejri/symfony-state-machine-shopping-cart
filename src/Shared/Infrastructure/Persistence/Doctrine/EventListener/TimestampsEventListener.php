<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\EventListener;

use App\Shared\Domain\Primitive\Entity\HasTimestampsInterface;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
final class TimestampsEventListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof HasTimestampsInterface) {
            return;
        }

        $entity->setCreatedAt(new DateTime());
        $entity->setUpdatedAt(new DateTime());
    }
}
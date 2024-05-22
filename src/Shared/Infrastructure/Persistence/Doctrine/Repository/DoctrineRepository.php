<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Repository;

use App\Shared\Domain\Primitive\Entity\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract readonly class DoctrineRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    protected function getRepository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder();
    }

    protected function persist(Entity $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    protected function remove(Entity $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
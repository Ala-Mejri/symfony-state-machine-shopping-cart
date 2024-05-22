<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\City\Persistence\Doctrine\Repository;

use App\Core\Domain\City\Entity\City;
use App\Core\Domain\City\Repository\CityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CityRepository implements CityRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function findByCountryId(int $countryId): array
    {
        return $this->entityManager->createQueryBuilder()
            ->from(City::class, 'c')
            ->where('c.country = :countryId')
            ->setParameter('countryId', $countryId)
            ->getQuery()
            ->getResult();
    }
}

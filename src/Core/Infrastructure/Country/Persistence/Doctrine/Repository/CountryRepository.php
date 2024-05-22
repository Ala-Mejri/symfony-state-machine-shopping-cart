<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Country\Persistence\Doctrine\Repository;

use App\Core\Domain\Country\Entity\Country;
use App\Core\Domain\Country\Repository\CountryRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class CountryRepository extends DoctrineRepository implements CountryRepositoryInterface
{
    public function getFirst(): ?Country
    {
        return $this->createQueryBuilder()
            ->from(Country::class, 'c')
            ->setMaxResults(1)
            ->select('c')
            ->getQuery()
            ->getSingleResult();
    }

    public function create(Country $country): void
    {
        $this->persist($country);
    }
}

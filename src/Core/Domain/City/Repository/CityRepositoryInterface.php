<?php

declare(strict_types=1);

namespace App\Core\Domain\City\Repository;

use App\Core\Domain\City\Entity\City;

interface CityRepositoryInterface
{
    /**
     * @return City[]
     */
    public function findByCountryId(int $countryId): array;
}
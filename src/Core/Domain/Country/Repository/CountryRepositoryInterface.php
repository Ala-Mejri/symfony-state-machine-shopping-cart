<?php

declare(strict_types=1);

namespace App\Core\Domain\Country\Repository;

use App\Core\Domain\Country\Entity\Country;

interface CountryRepositoryInterface
{
    public function getFirst(): ?Country;

    public function create(Country $country): void;
}
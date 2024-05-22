<?php

declare(strict_types=1);

namespace App\Core\Domain\City\Factory;

use App\Core\Domain\City\Entity\City;

final class CityFactory
{
    public function create(string $name): City
    {
        return (new City())->setName($name);
    }
}
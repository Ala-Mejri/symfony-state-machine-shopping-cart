<?php

declare(strict_types=1);

namespace App\Core\Domain\Country\Factory;

use App\Core\Domain\City\Factory\CityFactory;
use App\Core\Domain\Country\Entity\Country;

final readonly class CountryFactory
{
    public function __construct(private CityFactory $cityFactory)
    {
    }

    public function create(string $name, bool $isMemberOfEu, ?array $cities = []): Country
    {
        $country = (new Country())
            ->setName($name)
            ->setIsMemberOfEu($isMemberOfEu);

        foreach ($cities as $cityName) {
            $country->addCity($this->cityFactory->create($cityName));
        }

        return $country;
    }
}
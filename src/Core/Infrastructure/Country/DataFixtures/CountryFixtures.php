<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Country\DataFixtures;

use App\Core\Application\Country\Command\CreateCountry\CreateCountryCommand;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class CountryFixtures extends Fixture
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createAustralia();
        $this->createAustria();
        $this->createCanada();
        $this->createGermany();
        $this->createSwitzerland();
        $this->createUnitedStates();
    }

    private function createAustralia(): void
    {
        $this->createCountry('Australia', false, [
            'Queensland',
            'Victoria',
            'Tasmania',
            'New South Wales',
            'Western Australia',
            'South Australia',
        ]);
    }

    private function createAustria(): void
    {
        $this->createCountry('Austria', true, [
            'Vienna',
            'Graz',
            'Villach',
            'Salzburg',
        ]);
    }

    private function createCanada(): void
    {
        $this->createCountry('Canada', false, [
            'Toronto',
            'Vancouver',
            'Montreal',
            'Québec City',
        ]);
    }

    private function createGermany(): void
    {
        $this->createCountry('Germany', true, [
            'Berlin',
            'Munich',
            'Hamburg',
            'Frankfurt',
        ]);
    }

    private function createSwitzerland(): void
    {
        $this->createCountry('Switzerland', true, [
            'Zürich',
            'Bern',
            'Basel',
            'Lucerne',
        ]);
    }

    private function createUnitedStates(): void
    {
        $this->createCountry('United States', false, [
            'New York',
            'California',
            'Texas',
            'Washington',
        ]);
    }

    private function createCountry(string $name, bool $isMemberOfEu, array $cities): void
    {
        $this->commandBus->dispatch(
            new CreateCountryCommand(
                $name,
                $isMemberOfEu,
                $cities,
            ),
        );
    }
}

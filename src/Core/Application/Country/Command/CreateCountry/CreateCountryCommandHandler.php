<?php

declare(strict_types=1);

namespace App\Core\Application\Country\Command\CreateCountry;

use App\Core\Domain\Country\Factory\CountryFactory;
use App\Core\Domain\Country\Repository\CountryRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class CreateCountryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CountryFactory             $factory,
    )
    {
    }

    public function __invoke(CreateCountryCommand $command): void
    {
        $country = $this->factory->create(
            $command->getName(),
            $command->isMemberOfEu(),
            $command->getCities(),
        );

        $this->repository->create($country);
    }
}
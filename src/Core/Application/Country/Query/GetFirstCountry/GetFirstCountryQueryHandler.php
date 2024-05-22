<?php

declare(strict_types=1);

namespace App\Core\Application\Country\Query\GetFirstCountry;

use App\Core\Domain\Country\Entity\Country;
use App\Core\Domain\Country\Repository\CountryRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;

final readonly class GetFirstCountryQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CountryRepositoryInterface $repository)
    {
    }

    public function __invoke(GetFirstCountryQuery $query): Country
    {
        return $this->repository->getFirst();
    }
}
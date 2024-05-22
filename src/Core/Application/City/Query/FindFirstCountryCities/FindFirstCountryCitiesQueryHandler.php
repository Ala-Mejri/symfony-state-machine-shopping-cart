<?php

declare(strict_types=1);

namespace App\Core\Application\City\Query\FindFirstCountryCities;

use App\Core\Domain\City\Repository\CityRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;

final readonly class FindFirstCountryCitiesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CityRepositoryInterface $repository)
    {
    }

    public function __invoke(FindFirstCountryCitiesQuery $query): array
    {
       return $this->repository->findByCountryId(1);
    }
}
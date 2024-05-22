<?php

declare(strict_types=1);

namespace App\Core\Application\Country\Command\CreateCountry;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class CreateCountryCommand implements CommandInterface
{
    public function __construct(private string $name, private bool $isMemberOfEu, private array $cities = [])
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isMemberOfEu(): bool
    {
        return $this->isMemberOfEu;
    }

    public function getCities(): array
    {
        return $this->cities;
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Domain\City\Entity;

use App\Core\Domain\Country\Entity\Country;
use App\Shared\Domain\Primitive\Entity\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class City extends Entity
{
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    private ?Country $country = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

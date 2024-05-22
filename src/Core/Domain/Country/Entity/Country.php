<?php

declare(strict_types=1);

namespace App\Core\Domain\Country\Entity;

use App\Core\Domain\City\Entity\City;
use App\Shared\Domain\Primitive\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Country extends Entity
{
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    private ?bool $isMemberOfEu = null;

    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isIsMemberOfEu(): ?bool
    {
        return $this->isMemberOfEu;
    }

    public function setIsMemberOfEu(bool $isMemberOfEu): static
    {
        $this->isMemberOfEu = $isMemberOfEu;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function removeCity(City $city): static
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getCountry() === $this) {
                $city->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Domain\DeliveryAddress\Entity;

use App\Core\Domain\City\Entity\City;
use App\Shared\Domain\Primitive\Entity\Entity;
use Symfony\Component\Validator\Constraints as Assert;

abstract class DeliveryAddress extends Entity
{
    #[Assert\Length(max: 50)]
    protected ?string $name = null;

    #[Assert\Email]
    #[Assert\Length(max: 100)]
    protected ?string $email = null;

    #[Assert\Positive]
    #[Assert\Length(max: 10)]
    protected ?string $telephoneNumber = null;

    #[Assert\Length(max: 150)]
    protected ?string $street = null;

    #[Assert\Positive]
    #[Assert\Length(max: 8)]
    protected ?int $postalCode = null;

    #[Assert\Length(max: 12)]
    protected ?string $taxNumber = null;

    protected ?City $city = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephoneNumber(): ?string
    {
        return $this->telephoneNumber;
    }

    public function setTelephoneNumber(string $telephoneNumber): static
    {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName()
            . ', ' . $this->getStreet()
            . ' ' . $this->getPostalCode()
            . ' ' . $this->getCity()
            . ', ' . $this->getCity()->getCountry();
    }

    public function equals(self $deliveryAddress): bool
    {
        return $this->getName() === $deliveryAddress->getName()
            && $this->getEmail() === $deliveryAddress->getEmail()
            && $this->getTelephoneNumber() === $deliveryAddress->getTelephoneNumber()
            && $this->getStreet() === $deliveryAddress->getStreet()
            && $this->getTaxNumber() === $deliveryAddress->getTaxNumber()
            && $this->getCity() === $deliveryAddress->getCity();
    }
}
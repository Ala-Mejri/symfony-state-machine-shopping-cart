<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\CreateOrderDeliveryAddress;

use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Order\Entity\Order;
use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class CreateOrderDeliveryAddressCommand implements CommandInterface
{
    public function __construct(
        private string  $name,
        private string  $email,
        private string  $street,
        private int     $postalCode,
        private string  $telephoneNumber,
        private ?string $taxNumber,
        private City    $city,
        private Order   $order,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    public function getTelephoneNumber(): string
    {
        return $this->telephoneNumber;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
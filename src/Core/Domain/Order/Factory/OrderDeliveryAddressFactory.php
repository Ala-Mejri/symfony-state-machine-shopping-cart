<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Factory;

use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Entity\UserDeliveryAddress;

class OrderDeliveryAddressFactory
{
    public function create(
        string  $name,
        string  $email,
        string  $street,
        int     $postalCode,
        string  $telephoneNumber,
        ?string $taxNumber,
        City    $city,
        Order   $order,
    ): OrderDeliveryAddress
    {
        return (new OrderDeliveryAddress())
            ->setName($name)
            ->setEmail($email)
            ->setStreet($street)
            ->setPostalCode($postalCode)
            ->setTelephoneNumber($telephoneNumber)
            ->setTaxNumber($taxNumber)
            ->setCity($city)
            ->setOrderRelation($order);
    }

    public function createFromUserDeliveryAddress(UserDeliveryAddress $userDeliveryAddress): OrderDeliveryAddress
    {
        return (new OrderDeliveryAddress())
            ->setName($userDeliveryAddress->getName())
            ->setEmail($userDeliveryAddress->getEmail())
            ->setStreet($userDeliveryAddress->getStreet())
            ->setPostalCode($userDeliveryAddress->getPostalCode())
            ->setTelephoneNumber($userDeliveryAddress->getTelephoneNumber())
            ->setTaxNumber($userDeliveryAddress->getTaxNumber())
            ->setCity($userDeliveryAddress->getCity());
    }

    public function createFromUser(User $user): OrderDeliveryAddress
    {
        return (new OrderDeliveryAddress())
            ->setName($user->getName())
            ->setEmail($user->getEmail());
    }
}
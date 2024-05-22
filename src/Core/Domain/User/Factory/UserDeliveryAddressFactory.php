<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Factory;

use App\Core\Domain\City\Entity\City;
use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Entity\UserDeliveryAddress;

final class UserDeliveryAddressFactory
{
    public function create(
        string  $name,
        string  $email,
        string  $street,
        int     $postalCode,
        string  $telephoneNumber,
        ?string $taxNumber,
        City    $city,
        User    $user,
    ): UserDeliveryAddress
    {
        $userDeliveryAddress = new UserDeliveryAddress();

        $userDeliveryAddress
            ->setName($name)
            ->setEmail($email)
            ->setStreet($street)
            ->setPostalCode($postalCode)
            ->setTelephoneNumber($telephoneNumber)
            ->setTaxNumber($taxNumber)
            ->setCity($city)
            ->setUser($user);

        return $userDeliveryAddress;
    }
}
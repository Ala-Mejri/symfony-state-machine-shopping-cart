<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Repository;

use App\Core\Domain\User\Entity\UserDeliveryAddress;

interface UserDeliveryAddressRepositoryInterface
{
    public function create(UserDeliveryAddress $userDeliveryAddress): void;

    public function update(UserDeliveryAddress $userDeliveryAddress): void;

    public function delete(UserDeliveryAddress $userDeliveryAddress): void;

    public function find(int $id): ?UserDeliveryAddress;
}
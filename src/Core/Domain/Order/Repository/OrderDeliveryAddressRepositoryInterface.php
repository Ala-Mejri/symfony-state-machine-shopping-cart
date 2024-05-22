<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Repository;

use App\Core\Domain\Order\Entity\OrderDeliveryAddress;

interface OrderDeliveryAddressRepositoryInterface
{
    public function create(OrderDeliveryAddress $orderDeliveryAddress): void;

    public function update(OrderDeliveryAddress $orderDeliveryAddress): void;

    public function delete(OrderDeliveryAddress $orderDeliveryAddress): void;

    public function find(int $id): ?OrderDeliveryAddress;
}
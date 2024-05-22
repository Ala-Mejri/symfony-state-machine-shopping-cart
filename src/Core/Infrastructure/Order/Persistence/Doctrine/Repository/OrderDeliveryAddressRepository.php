<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Order\Persistence\Doctrine\Repository;

use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\Order\Repository\OrderDeliveryAddressRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class OrderDeliveryAddressRepository extends DoctrineRepository implements OrderDeliveryAddressRepositoryInterface
{
    public function create(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        $this->persist($orderDeliveryAddress);
    }

    public function update(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        $this->persist($orderDeliveryAddress);
    }

    public function delete(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        $this->remove($orderDeliveryAddress);
    }

    public function find(int $id): ?OrderDeliveryAddress
    {
        return $this->getRepository(OrderDeliveryAddress::class)->find($id);
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\User\Persistence\Doctrine\Repository;

use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Domain\User\Repository\UserDeliveryAddressRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class UserDeliveryAddressRepository extends DoctrineRepository implements UserDeliveryAddressRepositoryInterface
{
    public function create(UserDeliveryAddress $userDeliveryAddress): void
    {
        $this->persist($userDeliveryAddress);
    }

    public function update(UserDeliveryAddress $userDeliveryAddress): void
    {
        $this->persist($userDeliveryAddress);
    }

    public function delete(UserDeliveryAddress $userDeliveryAddress): void
    {
        $this->remove($userDeliveryAddress);
    }

    public function find(int $id): ?UserDeliveryAddress
    {
        return $this->getRepository(UserDeliveryAddress::class)->find($id);
    }
}

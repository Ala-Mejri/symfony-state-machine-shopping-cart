<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Order\Persistence\Doctrine\Repository;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use DateTime;

final readonly class OrderRepository extends DoctrineRepository implements OrderRepositoryInterface
{
    public function create(Order $order): void
    {
        $this->persist($order);
    }

    public function update(Order $order): void
    {
        $this->persist($order);
    }

    public function deleteMany(array $ids): void
    {
        $this->createQueryBuilder()
            ->delete(Order::class, 'o')
            ->where('o.id in (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->execute();
    }

    public function find(int $id): ?Order
    {
        return $this->getRepository(Order::class)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findOrderedByUserId(int $userId, ?int $limit = null): array
    {
        return $this->createQueryBuilder()
            ->from(Order::class, 'o')
            ->where('o.status = :status')
            ->andWhere('o.user = :userId')
            ->setParameter('status', OrderStatusType::STATUS_ORDERED->value)
            ->setParameter('userId', $userId)
            ->select('o')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findIdsNotModifiedSince(DateTime $limitDateTime, int $limit = 10): array
    {
        return $this->createQueryBuilder()
            ->from(Order::class, 'o')
            ->where('o.status = :status')
            ->andWhere('o.updatedAt < :date')
            ->setParameter('status', OrderStatusType::STATUS_SHOPPING_CART->value)
            ->setParameter('date', $limitDateTime)
            ->select('o.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->getSingleColumnResult();
    }
}

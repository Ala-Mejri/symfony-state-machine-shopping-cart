<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Repository;

use App\Core\Domain\Order\Entity\Order;
use DateTime;

interface OrderRepositoryInterface
{
    public function create(Order $order): void;

    public function update(Order $order): void;

    public function deleteMany(array $ids): void;

    public function find(int $id): ?Order;

    /**
     * @return Order[]
     */
    public function findOrderedByUserId(int $userId, ?int $limit = null): array;

    /**
     * @return Order[]
     */
    public function findIdsNotModifiedSince(DateTime $limitDateTime, int $limit = 10): array;
}
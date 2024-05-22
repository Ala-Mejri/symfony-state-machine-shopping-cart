<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Query\FindOrder;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;

final readonly class FindOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    public function __invoke(FindOrderQuery $query): ?Order
    {
        return $this->repository->find($query->getId());
    }
}
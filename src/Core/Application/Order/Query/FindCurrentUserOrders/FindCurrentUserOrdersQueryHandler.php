<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Query\FindCurrentUserOrders;

use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;
use App\Shared\Application\Service\CurrentUserService;

final readonly class FindCurrentUserOrdersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private CurrentUserService       $currentUserService,
    )
    {
    }

    public function __invoke(FindCurrentUserOrdersQuery $query): array
    {
        $userId = $this->currentUserService->getUser()->getId();

        return $this->repository->findOrderedByUserId($userId);
    }
}
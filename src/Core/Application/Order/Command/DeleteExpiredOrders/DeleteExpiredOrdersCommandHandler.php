<?php

namespace App\Core\Application\Order\Command\DeleteExpiredOrders;

use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;
use DateTime;

final readonly class DeleteExpiredOrdersCommandHandler implements CommandHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteExpiredOrdersCommand $command): int
    {
        $days = $command->getDays();
        $limitDateTime = new DateTime("- $days days");

        $orderIds = $this->repository->findIdsNotModifiedSince($limitDateTime);

        $this->repository->deleteMany($orderIds);

        return count($orderIds);
    }
}
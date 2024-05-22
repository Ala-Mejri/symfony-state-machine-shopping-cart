<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\UpdateOrderStatus;

use App\Core\Domain\Order\Exception\OrderNotFoundException;
use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class UpdateOrderStatusCommandHandler implements CommandHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateOrderStatusCommand $command): void
    {
        $order = $this->repository->find($command->getId());

        if ($order === null) {
            throw new OrderNotFoundException($command->getId());
        }

        $order->setStatus($command->getStatus()->value);
        $this->repository->update($order);
    }
}
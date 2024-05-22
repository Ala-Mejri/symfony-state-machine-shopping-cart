<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\UpdateOrder;

use App\Core\Domain\Order\Exception\OrderNotFoundException;
use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateOrderCommand $command): void
    {
        $order = $this->repository->find($command->getId());

        if ($order === null) {
            throw new OrderNotFoundException($command->getId());
        }

        $order
            ->setStatus($command->getStatus())
            ->setUser($command->getUser())
            ->setItems($command->getItems())
            ->setDeliveryAddress($command->getDeliveryAddress());

        $this->repository->update($order);
    }
}
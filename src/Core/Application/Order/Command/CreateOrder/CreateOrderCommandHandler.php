<?php

namespace App\Core\Application\Order\Command\CreateOrder;

use App\Core\Domain\Order\Factory\OrderFactory;
use App\Core\Domain\Order\Repository\OrderRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(private OrderRepositoryInterface $repository, private OrderFactory $factory)
    {
    }

    public function __invoke(CreateOrderCommand $command): int
    {
        $order = $this->factory->create();

        $order
            ->setUser($command->getUser())
            ->setItems($command->getItems())
            ->setDeliveryAddress($command->getDeliveryAddress());

        $this->repository->create($order);

        return $order->getId();
    }
}
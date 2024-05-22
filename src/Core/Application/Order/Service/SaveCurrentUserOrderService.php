<?php

namespace App\Core\Application\Order\Service;

use App\Core\Application\Order\Command\CreateOrder\CreateOrderCommand;
use App\Core\Application\Order\Command\UpdateOrder\UpdateOrderCommand;
use App\Core\Application\Order\Query\FindOrder\FindOrderQuery;
use App\Core\Domain\Order\Entity\Order;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use App\Shared\Application\Service\CurrentUserService;

final readonly class SaveCurrentUserOrderService
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus,
        private CurrentUserService  $currentUserService,
    )
    {
    }

    public function save(Order $order): Order
    {
        if ($order->getId() === null) {
            return $this->create($order);
        }

        return $this->update($order);
    }

    private function create(Order $order): Order
    {
        $id = $this->commandBus->dispatch(
            new CreateOrderCommand(
                $this->currentUserService->getUser(),
                $order->getItems(),
                $order->getDeliveryAddress(),
            ),
        );

        return $this->queryBus->ask(new FindOrderQuery($id));
    }

    private function update(Order $order): Order
    {
        $this->commandBus->dispatch(
            new UpdateOrderCommand(
                $order->getId(),
                $order->getStatus(),
                $order->getUser(),
                $order->getItems(),
                $order->getDeliveryAddress(),
            ),
        );

        return $this->queryBus->ask(new FindOrderQuery($order->getId()));
    }
}
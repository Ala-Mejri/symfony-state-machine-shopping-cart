<?php

declare(strict_types=1);

namespace App\Core\Application\CheckoutProcess\Service;

use App\Core\Application\Order\Command\CreateOrderDeliveryAddress\CreateOrderDeliveryAddressCommand;
use App\Core\Application\User\Command\CreateUserDeliveryAddress\CreateUserDeliveryAddressCommand;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Shared\Application\Bus\Command\CommandBusInterface;

final readonly class CreateCheckoutDeliveryAddressService
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    public function createDeliveryAddresses(Order $order, OrderDeliveryAddress $orderDeliveryAddress): void
    {
        if ($orderDeliveryAddress->getId() !== null) {
            return;
        }

        $this->createOrderDeliveryAddress($orderDeliveryAddress, $order);
        $this->createUserDeliveryAddress($orderDeliveryAddress);
    }

    private function createOrderDeliveryAddress(OrderDeliveryAddress $orderDeliveryAddress, Order $order): void
    {
        $this->commandBus->dispatch(
            new CreateOrderDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
                $order,
            ),
        );
    }

    private function createUserDeliveryAddress(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        $this->commandBus->dispatch(
            new CreateUserDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
            ),
        );
    }
}
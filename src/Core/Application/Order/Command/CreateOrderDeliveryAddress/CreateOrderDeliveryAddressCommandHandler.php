<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\CreateOrderDeliveryAddress;

use App\Core\Domain\Order\Factory\OrderDeliveryAddressFactory;
use App\Core\Domain\Order\Repository\OrderDeliveryAddressRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class CreateOrderDeliveryAddressCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderDeliveryAddressRepositoryInterface $repository,
        private OrderDeliveryAddressFactory    $factory,
    )
    {
    }

    public function __invoke(CreateOrderDeliveryAddressCommand $command): void
    {
        $orderDeliveryAddress = $this->factory->create(
            $command->getName(),
            $command->getEmail(),
            $command->getStreet(),
            $command->getPostalCode(),
            $command->getTelephoneNumber(),
            $command->getTaxNumber(),
            $command->getCity(),
            $command->getOrder(),
        );

        $this->repository->create($orderDeliveryAddress);
    }
}
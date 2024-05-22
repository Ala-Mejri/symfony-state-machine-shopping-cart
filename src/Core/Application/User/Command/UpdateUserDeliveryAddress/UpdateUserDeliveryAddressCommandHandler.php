<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\UpdateUserDeliveryAddress;

use App\Core\Domain\User\Exception\UserDeliveryAddressNotFoundException;
use App\Core\Domain\User\Repository\UserDeliveryAddressRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class UpdateUserDeliveryAddressCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserDeliveryAddressRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateUserDeliveryAddressCommand $command): void
    {
        $userDeliveryAddress = $this->repository->find($command->getId());

        if ($userDeliveryAddress === null) {
            throw new UserDeliveryAddressNotFoundException($command->getId());
        }

        $userDeliveryAddress->setName($command->getName());
        $userDeliveryAddress->setCity($command->getCity());
        $userDeliveryAddress->setTaxNumber($command->getTaxNumber());
        $userDeliveryAddress->setStreet($command->getStreet());
        $userDeliveryAddress->setPostalCode($command->getPostalCode());
        $userDeliveryAddress->setTelephoneNumber($command->getTelephoneNumber());
        $userDeliveryAddress->setEmail($command->getEmail());

        $this->repository->create($userDeliveryAddress);
    }
}
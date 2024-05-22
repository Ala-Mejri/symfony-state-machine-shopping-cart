<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\CreateUserDeliveryAddress;

use App\Core\Domain\User\Factory\UserDeliveryAddressFactory;
use App\Core\Domain\User\Repository\UserDeliveryAddressRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;
use App\Shared\Application\Service\CurrentUserService;

final readonly class CreateUserDeliveryAddressCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserDeliveryAddressRepositoryInterface $repository,
        private UserDeliveryAddressFactory $factory,
        private CurrentUserService $currentUserService,
    )
    {
    }

    public function __invoke(CreateUserDeliveryAddressCommand $command): void
    {
        $userDeliveryAddress = $this->factory->create(
            $command->getName(),
            $command->getEmail(),
            $command->getStreet(),
            $command->getPostalCode(),
            $command->getTelephoneNumber(),
            $command->getTaxNumber(),
            $command->getCity(),
            $this->currentUserService->getUser(),
        );

        $this->repository->create($userDeliveryAddress);
    }
}
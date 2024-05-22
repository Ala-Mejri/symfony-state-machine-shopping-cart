<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\DeleteUserDeliveryAddress;

use App\Core\Domain\User\Exception\UserDeliveryAddressNotFoundException;
use App\Core\Domain\User\Repository\UserDeliveryAddressRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;
use App\Shared\Application\Service\CurrentUserService;
use App\Shared\Domain\Primitive\Exception\EntityAccessForbiddenException;

final readonly class DeleteUserDeliveryAddressCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserDeliveryAddressRepositoryInterface $repository,
        private CurrentUserService                     $currentUserService,
    )
    {
    }

    /**
     * @throws EntityAccessForbiddenException
     */
    public function __invoke(DeleteUserDeliveryAddressCommand $query): void
    {
        $userDeliveryAddress = $this->repository->find($query->getId());

        if ($userDeliveryAddress === null) {
            throw new UserDeliveryAddressNotFoundException($query->getId());
        }

        if (!$this->currentUserService->isOwner($userDeliveryAddress)) {
            throw new EntityAccessForbiddenException();
        }

        $this->repository->delete($userDeliveryAddress);
    }
}
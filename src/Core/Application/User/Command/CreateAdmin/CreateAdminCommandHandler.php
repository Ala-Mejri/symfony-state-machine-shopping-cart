<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\CreateAdmin;

use App\Core\Domain\User\Factory\UserFactory;
use App\Core\Domain\User\Repository\UserRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateAdminCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface     $repository,
        private UserFactory        $factory,
        private UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function __invoke(CreateAdminCommand $command): void
    {
        $user = $this->factory->createAdmin(
            $command->getName(),
            $command->getEmail(),
            $command->getPlainPassword(),
        );

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getPlainPassword());
        $user->setPassword($hashedPassword);

        $this->repository->create($user);
    }
}
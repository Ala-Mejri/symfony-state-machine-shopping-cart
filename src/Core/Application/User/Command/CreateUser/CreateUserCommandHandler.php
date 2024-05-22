<?php

declare(strict_types=1);

namespace App\Core\Application\User\Command\CreateUser;

use App\Core\Domain\User\Factory\UserFactory;
use App\Core\Domain\User\Repository\UserRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface     $repository,
        private UserFactory        $factory,
        private UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = $this->factory->create(
            $command->getName(),
            $command->getEmail(),
            $command->getPlainPassword(),
        );

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getPlainPassword());
        $user->setPassword($hashedPassword);

        $this->repository->create($user);
    }
}
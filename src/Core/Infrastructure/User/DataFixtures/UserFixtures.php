<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\User\DataFixtures;

use App\Core\Application\User\Command\CreateAdmin\CreateAdminCommand;
use App\Core\Application\User\Command\CreateUser\CreateUserCommand;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->commandBus->dispatch(new CreateAdminCommand(
            'Admin',
            'admin@random-email.de',
            '123456',
        ));

        $this->commandBus->dispatch(new CreateUserCommand(
            'User',
            'user@random-email.de',
            '123456',
        ));
    }
}

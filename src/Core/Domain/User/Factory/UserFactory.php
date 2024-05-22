<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Factory;

use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Enum\UserRoleType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function createAdmin(string $name, string $email, string $password): User
    {
        $user = $this->create($name, $email, $password);
        $user->setRoles([UserRoleType::ROLE_ADMIN->value]);

        return $user;
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User();
        $user
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );

        return $user;
    }
}
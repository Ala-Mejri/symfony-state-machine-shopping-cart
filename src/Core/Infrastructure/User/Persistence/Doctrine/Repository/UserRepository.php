<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\User\Persistence\Doctrine\Repository;

use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Repository\UserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    public function create(User $user): void
    {
        $this->persist($user);
    }

    public function find(int $id): ?User
    {
        return $this->getRepository(User::class)->find($id);
    }
}

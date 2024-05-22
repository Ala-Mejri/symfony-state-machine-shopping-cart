<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Repository;

use App\Core\Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    public function find(int $id): ?User;
}
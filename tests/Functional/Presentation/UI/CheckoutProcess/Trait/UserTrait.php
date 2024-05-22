<?php

namespace App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait;

use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Repository\UserRepositoryInterface;

trait UserTrait
{
    private function getUser(): User
    {
        $userRepository = self::getContainer()->get(UserRepositoryInterface::class);
        assert($userRepository instanceof UserRepositoryInterface);

        return $userRepository->find(1);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Enum;

enum UserRoleType: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';

    case ROLE_USER = 'ROLE_USER';
}
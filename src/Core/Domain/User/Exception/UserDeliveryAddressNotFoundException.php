<?php

declare(strict_types=1);

namespace App\Core\Domain\User\Exception;

use App\Shared\Domain\Primitive\Exception\EntityNotFoundException;
use Throwable;

final class UserDeliveryAddressNotFoundException extends EntityNotFoundException
{
    public function __construct(int $id, ?Throwable $previous = null)
    {
        $message = sprintf('User delivery address with id "%s" was not found', $id);

        parent::__construct($message, $previous);
    }
}
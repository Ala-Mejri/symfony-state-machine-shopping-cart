<?php

declare(strict_types=1);

namespace App\Shared\Domain\Primitive\Exception;

use Exception;
use Throwable;

final class EntityAccessForbiddenException extends Exception
{
    public function __construct(string $message = 'Access forbidden', ?Throwable $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}

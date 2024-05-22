<?php

declare(strict_types=1);

namespace App\Shared\Domain\Primitive\Exception;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

class EntityNotFoundException extends ResourceNotFoundException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
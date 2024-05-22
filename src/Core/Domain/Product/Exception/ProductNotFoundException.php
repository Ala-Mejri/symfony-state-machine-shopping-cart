<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Exception;

use App\Shared\Domain\Primitive\Exception\EntityNotFoundException;
use Throwable;

final class ProductNotFoundException extends EntityNotFoundException
{
    public function __construct(int $id, ?Throwable $previous = null)
    {
        $message = sprintf('Product with id "%s" was not found', $id);

        parent::__construct($message, $previous);
    }
}
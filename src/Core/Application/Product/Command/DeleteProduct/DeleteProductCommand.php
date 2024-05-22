<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Command\DeleteProduct;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class DeleteProductCommand implements CommandInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
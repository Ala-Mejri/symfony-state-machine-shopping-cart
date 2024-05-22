<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Query\FindProduct;

use App\Shared\Application\Bus\Query\QueryInterface;

final readonly class FindProductQuery implements QueryInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
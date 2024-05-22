<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Query\FindOrder;

use App\Shared\Application\Bus\Query\QueryInterface;

final readonly class FindOrderQuery implements QueryInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
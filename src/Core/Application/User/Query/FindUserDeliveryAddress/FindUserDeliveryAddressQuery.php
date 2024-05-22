<?php

declare(strict_types=1);

namespace App\Core\Application\User\Query\FindUserDeliveryAddress;

use App\Shared\Application\Bus\Query\QueryInterface;

final readonly class FindUserDeliveryAddressQuery implements QueryInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
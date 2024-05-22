<?php

namespace App\Core\Application\Order\Command\DeleteExpiredOrders;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class DeleteExpiredOrdersCommand implements CommandInterface
{
    public function __construct(private int $days)
    {
    }

    public function getDays(): int
    {
        return $this->days;
    }
}
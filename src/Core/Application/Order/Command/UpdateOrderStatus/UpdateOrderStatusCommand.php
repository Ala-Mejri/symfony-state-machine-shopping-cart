<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\UpdateOrderStatus;

use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class UpdateOrderStatusCommand implements CommandInterface
{
    public function __construct(private int $id, private OrderStatusType $status)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): OrderStatusType
    {
        return $this->status;
    }
}
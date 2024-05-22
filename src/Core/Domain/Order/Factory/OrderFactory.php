<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Factory;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Enum\OrderStatusType;

final class OrderFactory
{
    public function create(): Order
    {
        return (new Order())->setStatus(OrderStatusType::STATUS_SHOPPING_CART->value);
    }
}
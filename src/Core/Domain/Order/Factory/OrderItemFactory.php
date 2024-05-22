<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Factory;

use App\Core\Domain\Order\Entity\OrderItem;
use App\Core\Domain\Product\Entity\Product;

final class OrderItemFactory
{
    public function create(Product $product): OrderItem
    {
        return (new OrderItem())->setProduct($product);
    }
}
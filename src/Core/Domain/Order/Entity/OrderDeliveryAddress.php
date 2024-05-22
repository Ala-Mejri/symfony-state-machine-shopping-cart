<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Entity;

use App\Core\Domain\DeliveryAddress\Entity\DeliveryAddress;

class OrderDeliveryAddress extends DeliveryAddress
{
    private ?Order $orderRelation = null;

    public function getOrderRelation(): ?Order
    {
        return $this->orderRelation;
    }

    public function setOrderRelation(Order $orderRelation): static
    {
        $this->orderRelation = $orderRelation;

        return $this;
    }
}

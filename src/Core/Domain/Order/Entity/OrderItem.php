<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Entity;

use App\Core\Domain\Product\Entity\Product;
use App\Shared\Domain\Primitive\Entity\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class OrderItem extends Entity
{
    private ?Product $product = null;

    #[Assert\Positive]
    #[Assert\LessThanOrEqual(100)]
    #[Assert\GreaterThanOrEqual(1)]
    private ?int $quantity = 1;

    private ?Order $orderRelation = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity = 1): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderRelation(): ?Order
    {
        return $this->orderRelation;
    }

    public function setOrderRelation(?Order $orderRelation): static
    {
        $this->orderRelation = $orderRelation;

        return $this;
    }

    public function equals(OrderItem $item): bool
    {
        return $this->getProduct()->getId() === $item->getProduct()->getId();
    }

    public function getTotal(): float
    {
        return $this->getProduct()->getPrice() * $this->getQuantity();
    }

    public function __toString(): string
    {
        return (string)$this->getProduct();
    }
}

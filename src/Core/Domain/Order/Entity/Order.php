<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Entity;

use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Core\Domain\User\Entity\User;
use App\Shared\Domain\Primitive\Entity\BelongsToUserInterface;
use App\Shared\Domain\Primitive\Entity\Entity;
use App\Shared\Domain\Primitive\Entity\HasTimestampsInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Order extends Entity implements HasTimestampsInterface, BelongsToUserInterface
{
    private const SHIPPING_COST = 5;
    private const VAT_PERCENTAGE = 19;

    #[Assert\Choice([OrderStatusType::STATUS_SHOPPING_CART->value, OrderStatusType::STATUS_DELIVERY_ADDRESS->value, OrderStatusType::STATUS_SUMMARY_FOR_PURCHASE->value, OrderStatusType::STATUS_ORDERED->value])]
    private ?string $status = null;

    private ?DateTimeInterface $createdAt = null;

    private ?DateTimeInterface $updatedAt = null;

    private ?OrderDeliveryAddress $deliveryAddress = null;

    private ?User $user = null;

    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): static
    {
        foreach ($items as $item) {
            $item->setOrderRelation($this);
        }

        $this->items = $items;

        return $this;
    }

    public function addItem(OrderItem $item): static
    {
        foreach ($this->getItems() as $existingItem) {
            // If the item already exists, update the quantity
            if ($existingItem->equals($item)) {
                $quantity = $existingItem->getQuantity() + $item->getQuantity();
                $existingItem->setQuantity($quantity);

                return $this;
            }
        }

        $this->items[] = $item;
        $item->setOrderRelation($this);

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        if ($this->items->removeElement($item)) {
            if ($item->getOrderRelation() === $this) {
                $item->setOrderRelation(null);
            }
        }

        return $this;
    }

    public function removeItems(): static
    {
        foreach ($this->getItems() as $item) {
            $this->removeItem($item);
        }

        return $this;
    }

    public function getShippingCost(): float
    {
        return static::SHIPPING_COST * $this->getItems()->count();
    }

    public function getVatCost(): float
    {
        return ($this->getSubtotal() * self::VAT_PERCENTAGE) / 100;
    }

    public function getSubtotal(): float
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function getTotal(): float
    {
        $sSubtotal = $this->getSubtotal();

        return $sSubtotal > 0
            ? $sSubtotal + $this->getVatCost() + $this->getShippingCost()
            : 0;
    }

    public function getDeliveryAddress(): ?OrderDeliveryAddress
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?OrderDeliveryAddress $deliveryAddress): static
    {
        if ($deliveryAddress !== null && $deliveryAddress->getOrderRelation() !== $this) {
            $deliveryAddress->setOrderRelation($this);
        }

        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->getItems()->count() === 0;
    }

    public function __toString(): string
    {
        return 'Order#' . $this->getId() . ' - €' . $this->getTotal();
    }
}

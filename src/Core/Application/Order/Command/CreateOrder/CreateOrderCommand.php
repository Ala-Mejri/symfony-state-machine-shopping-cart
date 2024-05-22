<?php

namespace App\Core\Application\Order\Command\CreateOrder;

use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\User\Entity\User;
use App\Shared\Application\Bus\Command\CommandInterface;
use Doctrine\Common\Collections\Collection;

final readonly class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        private User                  $user,
        private Collection            $items,
        private ?OrderDeliveryAddress $deliveryAddress = null,
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getDeliveryAddress(): ?OrderDeliveryAddress
    {
        return $this->deliveryAddress;
    }
}
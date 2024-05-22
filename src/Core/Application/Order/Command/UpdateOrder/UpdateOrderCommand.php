<?php

declare(strict_types=1);

namespace App\Core\Application\Order\Command\UpdateOrder;

use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\User\Entity\User;
use App\Shared\Application\Bus\Command\CommandInterface;
use Doctrine\Common\Collections\Collection;

final readonly class UpdateOrderCommand implements CommandInterface
{
    public function __construct(
        private int                   $id,
        private string                $status,
        private User                  $user,
        private Collection            $items,
        private ?OrderDeliveryAddress $deliveryAddress = null,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
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
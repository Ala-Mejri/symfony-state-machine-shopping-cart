<?php

namespace App\Core\Application\CheckoutProcess\Storage;

use App\Core\Domain\Order\Entity\Order;

interface CartSessionStorageInterface
{
    public function getCart(): ?Order;

    public function setCart(Order $order): void;

    public function removeCart(): void;
}
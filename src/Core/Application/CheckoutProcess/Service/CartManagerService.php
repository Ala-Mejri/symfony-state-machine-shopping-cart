<?php

declare(strict_types=1);

namespace App\Core\Application\CheckoutProcess\Service;

use App\Core\Application\CheckoutProcess\Storage\CartSessionStorageInterface;
use App\Core\Application\Order\Service\SaveCurrentUserOrderService;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Factory\OrderFactory;
use App\Core\Domain\Order\Factory\OrderItemFactory;
use App\Core\Domain\Product\Entity\Product;

final readonly class CartManagerService
{
    public function __construct(
        private OrderFactory                $orderFactory,
        private OrderItemFactory            $orderItemFactory,
        private CartSessionStorageInterface $cartSessionStorage,
        private SaveCurrentUserOrderService $saveCurrentUserOrderService,
    )
    {
    }

    public function getCurrentCart(): Order
    {
        return $this->cartSessionStorage->getCart() ?? $this->orderFactory->create();
    }

    public function removeCurrentCart(): void
    {
        $this->cartSessionStorage->removeCart();
    }

    public function saveCurrentCart(Order $order): void
    {
        // Persists the cart order in the database
        $order = $this->saveCurrentUserOrderService->save($order);

        // Persists the cart order in the session
        $this->cartSessionStorage->setCart($order);
    }

    public function addProduct(Product $product): void
    {
        $order = $this->getCurrentCart();

        $orderItem = $this->orderItemFactory->create($product);
        $order->addItem($orderItem);

        $this->saveCurrentCart($order);
    }
}

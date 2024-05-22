<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\CheckoutProcess\Storage;

use App\Core\Application\CheckoutProcess\Storage\CartSessionStorageInterface;
use App\Core\Application\Order\Query\FindOrder\FindOrderQuery;
use App\Core\Domain\Order\Entity\Order;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final readonly class CartSessionStorage implements CartSessionStorageInterface
{
    const SESSION_CART_KEY = 'sessionCartId';

    public function __construct(private RequestStack $requestStack, private QueryBusInterface $queryBus)
    {
    }

    public function getCart(): ?Order
    {
        $orderId = $this->getSession()->get(self::SESSION_CART_KEY);

        return $orderId !== null
            ? $this->queryBus->ask(new FindOrderQuery($orderId))
            : null;
    }

    public function setCart(Order $order): void
    {
        $this->getSession()->set(self::SESSION_CART_KEY, $order->getId());
    }

    public function removeCart(): void
    {
        $this->getSession()->remove(self::SESSION_CART_KEY);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}

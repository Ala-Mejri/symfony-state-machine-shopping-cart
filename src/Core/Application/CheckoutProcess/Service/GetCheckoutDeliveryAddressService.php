<?php

declare(strict_types=1);

namespace App\Core\Application\CheckoutProcess\Service;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\Order\Factory\OrderDeliveryAddressFactory;
use App\Core\Domain\User\Entity\User;
use App\Shared\Application\Service\CurrentUserService;

final readonly class GetCheckoutDeliveryAddressService
{
    public function __construct(
        private CurrentUserService          $currentUserService,
        private OrderDeliveryAddressFactory $orderDeliveryAddressFactory,
    )
    {
    }

    public function get(Order $order): OrderDeliveryAddress
    {
        $user = $this->currentUserService->getUser();

        return $order->getDeliveryAddress()
            ?? $this->getUserPrimaryDeliveryAddress($user)
            ?? $this->orderDeliveryAddressFactory->createFromUser($user);
    }

    private function getUserPrimaryDeliveryAddress(User $user): ?OrderDeliveryAddress
    {
        $deliveryAddress = $user->getPrimaryDeliveryAddress();

        return $deliveryAddress !== null
            ? $this->orderDeliveryAddressFactory->createFromUserDeliveryAddress($deliveryAddress)
            : null;
    }
}
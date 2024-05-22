<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\CheckoutProcess\EventSubscriber;

use App\Core\Application\Order\Command\UpdateOrderStatus\UpdateOrderStatusCommand;
use App\Core\Domain\CheckoutProcess\Enum\CheckoutProcessType;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;

final readonly class CheckoutProcessSubscriber implements EventSubscriberInterface
{
    private const EVENT_PREFIX = 'workflow.checkout_process.transition.';

    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            self::EVENT_PREFIX . CheckoutProcessType::TO_DELIVERY_ADDRESS->value => 'onTransitionToDeliveryAddress',
            self::EVENT_PREFIX . CheckoutProcessType::TO_SUMMARY_FOR_PURCHASE->value => 'onTransitionToSummaryForPurchases',
            self::EVENT_PREFIX . CheckoutProcessType::TO_ORDERED->value => 'onTransitionToOrdered',
        ];
    }

    public function onTransitionToDeliveryAddress(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), OrderStatusType::STATUS_DELIVERY_ADDRESS);
    }

    public function onTransitionToSummaryForPurchases(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), OrderStatusType::STATUS_SUMMARY_FOR_PURCHASE);
    }

    public function onTransitionToOrdered(TransitionEvent $event): void
    {
        $this->updateOrderStatus($event->getSubject(), OrderStatusType::STATUS_ORDERED);
    }

    public function updateOrderStatus(Order $order, OrderStatusType $status): void
    {
        $this->commandBus->dispatch(new UpdateOrderStatusCommand($order->getId(), $status));
    }
}

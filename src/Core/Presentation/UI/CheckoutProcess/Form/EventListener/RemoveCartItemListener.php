<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Form\EventListener;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderItem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class RemoveCartItemListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $order = $form->getData();

        if (!$order instanceof Order) {
            return;
        }

        $this->removesItemsWithZeroQuantity($form, $order);
    }

    private function removesItemsWithZeroQuantity(FormInterface $form, Order $order): void
    {
        foreach ($form->get('items')->all() as $child) {
            /* @var OrderItem $orderItem */
            $orderItem = $child->getData();

            if ($orderItem->getQuantity() === 0) {
                $order->removeItem($orderItem);
                break;
            }
        }
    }
}


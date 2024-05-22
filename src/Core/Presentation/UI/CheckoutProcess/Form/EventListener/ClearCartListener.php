<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Form\EventListener;

use App\Core\Domain\Order\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ClearCartListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    /**
     * Removes all items from the cart.
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $order = $form->getData();

        if (!$order instanceof Order || $form->get('clearItems')->getData() === false) {
            return;
        }

        $order->removeItems();
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowOrderConfirmation;

use App\Core\Domain\Order\Entity\Order;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class ShowOrderConfirmationResponder extends HtmlResponder
{
    public function redirect(Order $order): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.order.show', ['id' => $order->getId()]);
    }

    public function redirectToCart(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.cart');
    }
}

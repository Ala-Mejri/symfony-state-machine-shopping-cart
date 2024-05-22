<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowDeliveryAddress;

use App\Core\Domain\Order\Entity\Order;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowDeliveryAddressResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form, FormInterface $cartForm): Response
    {
        return $this->render('checkout/address.html.twig', [
            'form' => $form->createView(),
            'order' => $order,
            'cartForm' => $cartForm->createView(),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.summary');
    }

    public function redirectBack(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.address');
    }

    public function redirectToCart(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.cart');
    }
}

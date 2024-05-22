<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowCart;

use App\Core\Domain\Order\Entity\Order;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowCartResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form): Response
    {
        return $this->render('checkout/cart.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.cart');
    }
}

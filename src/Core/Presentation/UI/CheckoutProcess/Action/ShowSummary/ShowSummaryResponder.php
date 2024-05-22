<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowSummary;

use App\Core\Domain\Order\Entity\Order;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowSummaryResponder extends HtmlResponder
{
    public function respond(Order $order, FormInterface $form): Response
    {
        return $this->render('checkout/summary.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    public function redirectBack(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.summary');
    }

    public function redirectToCart(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.checkout.cart');
    }
}

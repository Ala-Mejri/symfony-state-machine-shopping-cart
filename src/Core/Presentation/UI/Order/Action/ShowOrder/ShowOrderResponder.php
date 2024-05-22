<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Order\Action\ShowOrder;

use App\Core\Domain\Order\Entity\Order;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class ShowOrderResponder extends HtmlResponder
{
    public function respond(Order $order): Response
    {
        return $this->render('checkout/ordered.html.twig', [
            'order' => $order,
        ]);
    }
}
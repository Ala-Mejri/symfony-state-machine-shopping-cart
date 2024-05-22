<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\ShowUserDeliveryAddress;

use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class ShowUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(UserDeliveryAddress $userDeliveryAddress): Response
    {
        return $this->render('address/detail.html.twig', [
            'userDeliveryAddress' => $userDeliveryAddress,
        ]);
    }
}
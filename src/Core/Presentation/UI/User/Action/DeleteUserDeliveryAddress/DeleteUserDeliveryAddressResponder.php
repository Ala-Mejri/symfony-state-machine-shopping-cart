<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\DeleteUserDeliveryAddress;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class DeleteUserDeliveryAddressResponder extends HtmlResponder
{
    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.dashboard');
    }
}
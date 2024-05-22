<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\CreateUserDeliveryAddress;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreateUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('address/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add a new delivery address',
        ]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.dashboard');
    }
}
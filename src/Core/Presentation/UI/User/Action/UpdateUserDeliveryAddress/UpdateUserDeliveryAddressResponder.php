<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\UpdateUserDeliveryAddress;

use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateUserDeliveryAddressResponder extends HtmlResponder
{
    public function respond(UserDeliveryAddress $userDeliveryAddress, FormInterface $form): Response
    {
        return $this->render('address/edit.html.twig', [
            'product' => $userDeliveryAddress,
            'form' => $form->createView(),
            'title' => 'Edit delivery address',
        ]);
    }

    public function redirect(UserDeliveryAddress $userDeliveryAddress): RedirectResponse
    {

        return $this->redirectionResponder->redirectToRoute('app.dashboard', [
            'id' => $userDeliveryAddress->getId(),
        ]);
    }
}
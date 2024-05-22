<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Authentication\Action\Registration;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class RegistrationResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('authentication/register.html.twig', ['form' => $form->createView()]);
    }

    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.home');
    }
}
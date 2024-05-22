<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Authentication\Action\Login;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final class LoginResponder extends HtmlResponder
{
    public function respond(string $lastUsername, ?AuthenticationException $error): Response
    {
        return $this->render('authentication/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Authentication\Action\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/login', name: 'app_login')]
final class LoginAction extends AbstractController
{
    public function __construct(
        private readonly LoginResponder      $responder,
        private readonly AuthenticationUtils $authenticationUtils,
    )
    {
    }

    public function __invoke(): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->responder->respond($lastUsername, $error);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Authentication\Action\Logout;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/logout', name: 'app_logout')]
final class LogoutAction extends AbstractController
{
    public function __invoke(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
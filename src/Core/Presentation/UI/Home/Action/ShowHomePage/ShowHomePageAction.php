<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Home\Action\ShowHomePage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app.home')]
final class ShowHomePageAction extends AbstractController
{
 public function __construct(private readonly ShowHomePageResponder $responder)
 {
 }

    public function __invoke(): Response
    {
        return $this->responder->respond();
    }
}

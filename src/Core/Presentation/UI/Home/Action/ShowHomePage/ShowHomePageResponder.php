<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Home\Action\ShowHomePage;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class ShowHomePageResponder extends HtmlResponder
{
    public function respond(): Response
    {
        return $this->render('home/home.html.twig');
    }
}
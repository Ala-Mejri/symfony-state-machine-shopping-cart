<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\ShowUserDashboard;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class ShowUserDashboardResponder extends HtmlResponder
{
    public function respond(array $orders): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'orders' => $orders,
        ]);
    }
}
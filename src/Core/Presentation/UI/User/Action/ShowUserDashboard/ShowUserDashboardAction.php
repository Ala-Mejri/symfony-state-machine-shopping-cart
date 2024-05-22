<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\ShowUserDashboard;

use App\Core\Application\Order\Query\FindCurrentUserOrders\FindCurrentUserOrdersQuery;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'app.dashboard')]
final class ShowUserDashboardAction extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface          $queryBus,
        private readonly ShowUserDashboardResponder $responder,
    )
    {
    }

    public function __invoke(): Response
    {
        $orders = $this->queryBus->ask(new FindCurrentUserOrdersQuery());

        return $this->responder->respond($orders);
    }
}
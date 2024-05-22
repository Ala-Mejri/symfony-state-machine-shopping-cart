<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Order\Action\ShowOrder;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Shared\Application\Service\CurrentUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/order/{id}', name: 'app.order.show')]
final class ShowOrderAction extends AbstractController
{
    public function __construct(
        private readonly ShowOrderResponder $responder,
        private readonly CurrentUserService $currentUserService,
    )
    {
    }

    public function __invoke(Order $order): Response
    {
        if (!$this->currentUserService->isOwner($order) || $order->getStatus() !== OrderStatusType::STATUS_ORDERED->value) {
            throw $this->responder->createAccessDeniedException();
        }

        return $this->responder->respond($order);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowOrderConfirmation;

use App\Core\Application\CheckoutProcess\Service\CartManagerService;
use App\Core\Domain\CheckoutProcess\Enum\CheckoutProcessType;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Shared\Presentation\Service\FlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/checkout/confirmation', name: 'app.checkout.confirmation')]
final class ShowOrderConfirmationAction extends AbstractController
{
    public function __construct(
        private readonly ShowOrderConfirmationResponder $responder,
        private readonly FlashService                   $flashService,
        private readonly WorkflowInterface              $checkoutProcessStateMachine,
        private readonly CartManagerService             $cartManagerService,
    )
    {
    }

    public function __invoke(): Response
    {
        $order = $this->cartManagerService->getCurrentCart();

        if (!$this->checkoutProcessStateMachine->can($order, CheckoutProcessType::TO_ORDERED->value)) {
            throw $this->responder->createAccessDeniedException('You cant access the order confirmation page!');
        }

        if ($order->isEmpty()) {
            return $this->responder->redirectToCart();
        }

        if (!$this->isCheckoutProcessStateMachineInOrderedPlace($order)) {
            $this->checkoutProcessStateMachine->apply($order, CheckoutProcessType::TO_ORDERED->value);
            $this->cartManagerService->removeCurrentCart();
            $this->flashService->addSuccessFlash('Your order was placed successfully!');
        }

        return $this->responder->redirect($order);
    }

    private function isCheckoutProcessStateMachineInOrderedPlace(Order $order): bool
    {
        $places = $this->checkoutProcessStateMachine->getMarking($order)->getPlaces();

        return in_array(OrderStatusType::STATUS_ORDERED->value, array_keys($places));
    }
}
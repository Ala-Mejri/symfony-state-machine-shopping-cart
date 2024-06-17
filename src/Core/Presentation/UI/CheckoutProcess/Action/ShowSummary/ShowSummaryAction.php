<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowSummary;

use App\Core\Application\CheckoutProcess\Service\CartManagerService;
use App\Core\Domain\CheckoutProcess\Enum\CheckoutProcessType;
use App\Core\Presentation\UI\CheckoutProcess\Action\Traits\HandleCartFormTrait;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/checkout/summary', name: 'app.checkout.summary')]
final class ShowSummaryAction extends AbstractController
{
    use HandleCartFormTrait;

    public function __construct(
        private readonly ActionFormHandler    $actionFormHandler,
        private readonly ShowSummaryResponder $responder,
        private readonly WorkflowInterface    $checkoutProcessStateMachine,
        private readonly CartManagerService   $cartManagerService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentOrder();

        if (!$this->checkoutProcessStateMachine->can($order, CheckoutProcessType::TO_SUMMARY_FOR_PURCHASE->value)) {
            throw $this->responder->createAccessDeniedException('You cant access the summary page!');
        }

        if ($order->isEmpty()) {
            return $this->responder->redirectToCart();
        }

        $this->checkoutProcessStateMachine->apply($order, CheckoutProcessType::TO_SUMMARY_FOR_PURCHASE->value);

        $cartForm = $this->handleCartForm($request, $order);
        if ($this->actionFormHandler->isFormSubmittedAndValid($cartForm)) {
            $this->cartManagerService->saveCurrentOrder($order);

            return $this->responder->redirectBack();
        }

        return $this->responder->respond($order, $cartForm);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowDeliveryAddress;

use App\Core\Application\CheckoutProcess\Service\CartManagerService;
use App\Core\Application\CheckoutProcess\Service\CreateCheckoutDeliveryAddressService;
use App\Core\Application\CheckoutProcess\Service\GetCheckoutDeliveryAddressService;
use App\Core\Domain\CheckoutProcess\Enum\CheckoutProcessType;
use App\Core\Presentation\UI\CheckoutProcess\Action\Traits\HandleCartFormTrait;
use App\Core\Presentation\UI\Order\Form\OrderDeliveryAddressType;
use App\Shared\Presentation\Service\ActionFormHandler;
use App\Shared\Presentation\Service\FlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('checkout/address', name: 'app.checkout.address')]
final class ShowDeliveryAddressAction extends AbstractController
{
    use HandleCartFormTrait;

    public function __construct(
        private readonly ActionFormHandler                    $actionFormHandler,
        private readonly ShowDeliveryAddressResponder         $responder,
        private readonly FlashService                         $flashService,
        private readonly WorkflowInterface                    $checkoutProcessStateMachine,
        private readonly CartManagerService                   $cartManagerService,
        private readonly GetCheckoutDeliveryAddressService    $getOrderDeliveryAddress,
        private readonly CreateCheckoutDeliveryAddressService $saveCheckoutDeliveryAddress,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentCart();

        if (!$this->checkoutProcessStateMachine->can($order, CheckoutProcessType::TO_DELIVERY_ADDRESS->value)) {
            throw $this->responder->createAccessDeniedException('You cant access the delivery address page!');
        }

        if ($order->isEmpty()) {
            return $this->responder->redirectToCart();
        }

        $orderDeliveryAddress = $this->getOrderDeliveryAddress->get($order);
        $form = $this->actionFormHandler->handleFormRequest(OrderDeliveryAddressType::class, $request, $orderDeliveryAddress);

        if (!$request->isxmlhttprequest() && $this->actionFormHandler->isFormSubmittedAndValid($form)) {
            $this->saveCheckoutDeliveryAddress->createDeliveryAddresses($order, $form->getData());
            $this->checkoutProcessStateMachine->apply($order, CheckoutProcessType::TO_DELIVERY_ADDRESS->value);
            $this->flashService->addSuccessFlash('Your delivery address was saved successfully!');

            return $this->responder->redirect();
        }

        $cartForm = $this->handleCartForm($request, $order);
        if ($this->actionFormHandler->isFormSubmittedAndValid($cartForm)) {
            $this->cartManagerService->saveCurrentCart($order);

            return $this->responder->redirectBack();
        }

        return $this->responder->respond($order, $form, $cartForm);
    }
}

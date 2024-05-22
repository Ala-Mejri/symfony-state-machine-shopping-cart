<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\ShowCart;

use App\Core\Application\CheckoutProcess\Service\CartManagerService;
use App\Core\Presentation\UI\CheckoutProcess\Form\ShowCartType;
use App\Shared\Presentation\Service\ActionFormHandler;
use App\Shared\Presentation\Service\FlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'app.checkout.cart')]
final class ShowCartAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler  $actionFormHandler,
        private readonly ShowCartResponder  $responder,
        private readonly FlashService       $flashService,
        private readonly CartManagerService $cartManagerService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $order = $this->cartManagerService->getCurrentCart();
        $form = $this->actionFormHandler->handleFormRequest(ShowCartType::class, $request, $order);

        if ($this->actionFormHandler->isFormSubmittedAndValid($form)) {
            $this->cartManagerService->saveCurrentCart($order);

            return $this->responder->redirect();
        }

        if ($order->isEmpty()) {
            $this->flashService->addNoticeFlash('Your shopping cart is empty. Please add some products!');
        }

        return $this->responder->respond($order, $form);
    }
}

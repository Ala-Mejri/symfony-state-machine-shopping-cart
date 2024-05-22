<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Action\Traits;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Presentation\UI\CheckoutProcess\Form\CartType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait HandleCartFormTrait
{
    private function handleCartForm(Request $request, Order $order): FormInterface
    {
        $form = $this->actionFormHandler->handleFormRequest(CartType::class, $request, $order);

        if ($this->actionFormHandler->isFormSubmittedAndValid($form)) {
            $this->cartManagerService->saveCurrentCart($order);
        }

        return $form;
    }
}
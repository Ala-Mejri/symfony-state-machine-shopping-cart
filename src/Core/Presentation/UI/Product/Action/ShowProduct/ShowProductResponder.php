<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\ShowProduct;

use App\Core\Domain\Product\Entity\Product;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowProductResponder extends HtmlResponder
{
    public function respond(Product $product, FormInterface $form): Response
    {
        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    public function redirect(Product $product): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.detail', ['id' => $product->getId()]);
    }
}
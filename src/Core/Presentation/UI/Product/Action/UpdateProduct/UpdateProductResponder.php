<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\UpdateProduct;

use App\Core\Domain\Product\Entity\Product;
use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateProductResponder extends HtmlResponder
{
    public function respond(Product $product, FormInterface $form): Response
    {
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'title' => 'Edit product',
        ]);
    }

    public function redirect(Product $product): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.detail', ['id' => $product->getId()]);
    }
}
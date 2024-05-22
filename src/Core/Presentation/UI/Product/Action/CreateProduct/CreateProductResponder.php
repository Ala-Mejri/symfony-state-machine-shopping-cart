<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\CreateProduct;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreateProductResponder extends HtmlResponder
{
    public function respond(FormInterface $form): Response
    {
        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add a new product',
        ]);
    }

    public function redirect(int $id): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.detail', [
            'id' => $id,
        ]);
    }
}
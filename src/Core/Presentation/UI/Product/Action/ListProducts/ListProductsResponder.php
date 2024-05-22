<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\ListProducts;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class ListProductsResponder extends HtmlResponder
{
    public function respond(array $products): Response
    {
        return $this->render('product/list.html.twig', ['products' => $products]);
    }
}
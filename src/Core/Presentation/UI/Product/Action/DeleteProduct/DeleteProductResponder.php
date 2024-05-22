<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\DeleteProduct;

use App\Shared\Presentation\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class DeleteProductResponder extends HtmlResponder
{
    public function redirect(): RedirectResponse
    {
        return $this->redirectionResponder->redirectToRoute('app.product.list');
    }
}
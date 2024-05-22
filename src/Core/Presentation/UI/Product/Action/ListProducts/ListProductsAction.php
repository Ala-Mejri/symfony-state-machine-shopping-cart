<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Product\Action\ListProducts;

use App\Core\Application\Product\Query\ListProducts\ListProductsQuery;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'app.product.list')]
final class ListProductsAction extends AbstractController
{
    public function __construct(private readonly QueryBusInterface $queryBus, private readonly ListProductsResponder $responder)
    {
    }

    public function __invoke(): Response
    {
        $products = $this->queryBus->ask(new ListProductsQuery());

        return $this->responder->respond($products);
    }
}
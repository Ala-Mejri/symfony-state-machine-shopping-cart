<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Query\FindProduct;

use App\Core\Domain\Product\Entity\Product;
use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;

final readonly class FindProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(FindProductQuery $query): ?Product
    {
        $product = $this->repository->findOneWithImage($query->getId());

        if ($product === null) {
            throw new ProductNotFoundException($query->getId());
        }

        return $product;
    }
}
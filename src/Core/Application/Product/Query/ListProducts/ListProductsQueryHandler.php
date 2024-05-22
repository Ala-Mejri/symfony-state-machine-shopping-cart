<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Query\ListProducts;

use App\Core\Domain\Product\Entity\Product;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\Query\QueryHandlerInterface;

final readonly class ListProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    /**
     * @return Product[]
     */
    public function __invoke(ListProductsQuery $query): array
    {
       return $this->repository->findAllWithImages();
    }
}
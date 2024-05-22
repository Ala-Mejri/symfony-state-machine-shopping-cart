<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Product\Persistence\Doctrine\Repository;

use App\Core\Domain\Product\Entity\ProductImage;
use App\Core\Domain\Product\Repository\ProductImageRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class ProductImageRepository extends DoctrineRepository implements ProductImageRepositoryInterface
{
    public function update(ProductImage $productImage): void
    {
        $this->persist($productImage);
    }
}
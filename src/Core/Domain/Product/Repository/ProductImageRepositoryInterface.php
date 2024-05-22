<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Repository;

use App\Core\Domain\Product\Entity\ProductImage;

interface ProductImageRepositoryInterface
{
    public function update(ProductImage $productImage): void;
}
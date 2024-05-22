<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Factory;

use App\Core\Domain\Product\Entity\ProductImage;

final class ProductImageFactory
{
    public function create(string $path): ProductImage
    {
        return (new ProductImage())->setPath($path);
    }
}
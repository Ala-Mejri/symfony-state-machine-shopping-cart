<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Factory;

use App\Core\Domain\Product\Entity\Product;

final readonly class ProductFactory
{
    public function __construct(private ProductImageFactory $imageFactory)
    {
    }

    public function create(string $name, string $description, float $price, string $imagePath): Product
    {
        $image = $this->imageFactory->create($imagePath);

        return (new Product())
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setImage($image);
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Repository;

use App\Core\Domain\Product\Entity\Product;

interface ProductRepositoryInterface
{
    public function create(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;

    public function find(int $id): ?Product;

    /**
     * @return Product[]
     */
    public function findAll(): array;

    /**
     * @return Product[]
     */
    public function findAllWithImages(): array;

    public function findOneWithImage(int $id): ?Product;
}
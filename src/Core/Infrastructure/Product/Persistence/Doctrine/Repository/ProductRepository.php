<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Product\Persistence\Doctrine\Repository;

use App\Core\Domain\Product\Entity\Product;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

final readonly class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    public function create(Product $product): void
    {
        $this->persist($product);
    }

    public function update(Product $product): void
    {
        $this->persist($product);
    }

    public function delete(Product $product): void
    {
        $this->remove($product);
    }

    public function find(int $id): ?Product
    {
        return $this->getRepository(Product::class)->find( $id);
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder()
            ->from(Product::class, 'p')
            ->select('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findAllWithImages(): array
    {
        return $this->createQueryBuilder()
            ->from(Product::class, 'p')
            ->join('p.image', 'i')
            ->select(['p', 'i'])
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneWithImage(int $id): ?Product
    {
        return $this->createQueryBuilder()
            ->from(Product::class, 'p')
            ->join('p.image', 'i')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->select(['p', 'i'])
            ->getQuery()
            ->getOneOrNullResult();
    }
}

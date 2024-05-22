<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Command\CreateProduct;

use App\Core\Domain\Product\Factory\ProductFactory;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductFactory    $factory,
    )
    {
    }

    public function __invoke(CreateProductCommand $command): int
    {
        $product = $this->factory->create(
            $command->getName(),
            $command->getDescription(),
            $command->getPrice(),
            $command->getImagePath(),
        );

        $this->repository->create($product);

        return $product->getId();
    }
}
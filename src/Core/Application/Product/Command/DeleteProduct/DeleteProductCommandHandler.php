<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Command\DeleteProduct;

use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class DeleteProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->repository->find($command->getId());

        if ($product === null) {
            throw new ProductNotFoundException($command->getId());
        }

        $this->repository->delete($product);
    }
}
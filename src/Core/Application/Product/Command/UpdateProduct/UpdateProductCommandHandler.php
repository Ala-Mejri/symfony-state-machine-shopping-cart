<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Command\UpdateProduct;

use App\Core\Domain\Product\Exception\ProductNotFoundException;
use App\Core\Domain\Product\Repository\ProductImageRepositoryInterface;
use App\Core\Domain\Product\Repository\ProductRepositoryInterface;
use App\Shared\Application\Bus\Command\CommandHandlerInterface;

final readonly class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface      $repository,
        private ProductImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->repository->find($command->getId());

        if ($product === null) {
            throw new ProductNotFoundException($command->getId());
        }

        $image = $product->getImage();
        $image->setPath($command->getImagePath());
        $this->imageRepository->update($image);

        $product
            ->setName($command->getName())
            ->setDescription($command->getDescription())
            ->setPrice($command->getPrice())
            ->setImage($image);
        $this->repository->update($product);
    }
}
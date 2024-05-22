<?php

declare(strict_types=1);

namespace App\Core\Application\Product\Command\CreateProduct;

use App\Shared\Application\Bus\Command\CommandInterface;

final readonly class CreateProductCommand implements CommandInterface
{
    public function __construct(
        private string $name,
        private string $description,
        private float  $price,
        private string $imagePath,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }
}
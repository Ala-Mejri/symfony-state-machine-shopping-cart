<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Entity;

use App\Shared\Domain\Primitive\Entity\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ProductImage extends Entity
{
    #[Assert\Length(max: 255)]
    #[Assert\Url]
    private ?string $path = null;

    private ?Product $product = null;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->getPath();
    }
}

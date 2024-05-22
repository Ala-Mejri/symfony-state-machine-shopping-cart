<?php

declare(strict_types=1);

namespace App\Core\Domain\Product\Entity;

use App\Shared\Domain\Primitive\Entity\Entity;
use App\Shared\Domain\Primitive\Entity\HasTimestampsInterface;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends Entity implements HasTimestampsInterface
{
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[Assert\Length(max: 1000)]
    private ?string $description = null;

    #[Assert\Positive]
    #[Assert\LessThanOrEqual(1000000)]
    private ?float $price = null;

    private ?DateTimeInterface $createdAt = null;

    private ?DateTimeInterface $updatedAt = null;

    private ?ProductImage $image = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImage(): ?ProductImage
    {
        return $this->image;
    }

    public function setImage(ProductImage $image): static
    {
        if ($image->getProduct() !== $this) {
            $image->setProduct($this);
        }

        $this->image = $image;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

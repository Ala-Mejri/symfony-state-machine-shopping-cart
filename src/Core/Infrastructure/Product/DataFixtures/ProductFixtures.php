<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Product\DataFixtures;

use App\Core\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ProductFixtures extends Fixture
{
    const IMAGE_URLS = [
        'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
        'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-02.jpg',
        'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-03.jpg',
        'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-04.jpg',

        'https://tailwindui.com/img/ecommerce-images/home-page-04-trending-product-01.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-04-trending-product-02.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-04-trending-product-03.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-04-trending-product-04.jpg',

        'https://tailwindui.com/img/ecommerce-images/home-page-02-product-01.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-02-product-02.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-02-product-03.jpg',
        'https://tailwindui.com/img/ecommerce-images/home-page-02-product-04.jpg',

        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-03.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-04.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-05.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-06.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-07.jpg',
        'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-08.jpg',
    ];
    const DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';

    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $this->commandBus->dispatch(
                new CreateProductCommand(
                    'Product ' . $i + 1,
                    self::DESCRIPTION,
                    mt_rand(15, 50),
                    $this->getImagePath($i),
                ),
            );
        }
    }

    private function getImagePath(int $index): string
    {
        return self::IMAGE_URLS[$index]
            ?? self::IMAGE_URLS[array_rand(self::IMAGE_URLS)];
    }
}

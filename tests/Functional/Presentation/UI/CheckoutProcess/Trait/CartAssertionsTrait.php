<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait;

use PHPUnit\Framework\Assert;
use Symfony\Component\DomCrawler\Crawler;

trait CartAssertionsTrait
{
    private const SHIPPING_COST = 5;
    private const VAT_PERCENTAGE = 19;

    private static function assertCartItemsCountEquals(Crawler $crawler, int $expectedCount): void
    {
        $actualCount = $crawler->filter(self::PRODUCT_ITEM_CSS_SELECTOR)->count();

        Assert::assertEquals($expectedCount, $actualCount);
    }

    private static function assertCartIsEmpty(): void
    {
        self::assertSelectorExists('.alert-notice');
        self::assertSelectorTextSame('.alert-notice', 'Your shopping cart is empty. Please add some products!');
    }

    private static function assertCartTotalEquals(Crawler $crawler, $expectedTotal): void
    {
        $expectedTotal += self::SHIPPING_COST + ($expectedTotal * self::VAT_PERCENTAGE) / 100;
        $expectedTotal = round($expectedTotal, 2);

        $actualTotal = $crawler->filter('[data-id="order-total"]')->innerText();
        $actualTotal = (float)str_replace('€', '', $actualTotal);

        Assert::assertEquals($expectedTotal, $actualTotal);
    }

    private static function assertCartContainsProductWithQuantity(Crawler $crawler, string $productName, int $expectedQuantity): void
    {
        $actualQuantity = (int)self::getItemByProductName($crawler, $productName)
            ->filter('input[type="number"]')
            ->attr('value');

        Assert::assertEquals($expectedQuantity, $actualQuantity);
    }

    private static function assertCartNotContainsProduct(Crawler $crawler, string $productName): void
    {
        Assert::assertEmpty(
            self::getItemByProductName($crawler, $productName),
            "The cart should not contain the product \"$productName\"."
        );
    }

    private static function getItemByProductName(Crawler $crawler, string $productName): ?Crawler
    {
        return $crawler->filter(self::PRODUCT_ITEM_CSS_SELECTOR)->reduce(
            function (Crawler $node) use ($productName) {
                if (trim($node->filter('[itemprop="name"]')->getNode(0)->textContent) === $productName) {
                    return $node;
                }

                return false;
            }
        )?->eq(0);
    }
}
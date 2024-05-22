<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\UI\CheckoutProcess\Action;

use App\Core\Presentation\UI\CheckoutProcess\Action\ShowCart\ShowCartAction;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\CartAssertionsTrait;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\ProductTrait;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\UserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers ShowCartAction
 */
class ShowCartActionTest extends WebTestCase
{
    use CartAssertionsTrait;
    use ProductTrait;
    use UserTrait;

    const PRODUCT_ITEM_CSS_SELECTOR = '[itemtype="https://schema.org/Product"]';

    /**
     * @group Functional
     */
    public function testCartIsEmpty(): void
    {
        $client = self::createClient();
        $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartIsEmpty();
    }

    /**
     * @group Functional
     */
    public function testAddProductToCart(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartItemsCountEquals($crawler, 1);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 1);
        $this->assertCartTotalEquals($crawler, $product['price']);
    }

    /**
     * @group Functional
     */
    public function testAddProductTwiceToCart(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser());

        $product = $this->getRandomProduct($client);
        $crawler = $client->request('GET', $product['url']);

        for ($i = 0; $i < 2; $i++) {
            $form = $crawler->filter('form')->form();
            $client->submit($form);
            $crawler = $client->followRedirect();
        }

        // Go to the cart page
        $crawler = $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertCartItemsCountEquals($crawler, 1);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 2);
        $this->assertCartTotalEquals($crawler, $product['price'] * 2);
    }

    /**
     * @group Functional
     */
    public function testRemoveProductFromCart(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);

        // Go to the cart page
        $crawler = $client->request('GET', '/cart');

        // Remove the product from the cart
        $cartForm = $crawler->filter('form')->form([
            'show_cart[items][0][quantity]' => 0,
        ]);

        $client->submit($cartForm);
        $crawler = $client->followRedirect();

        $this->assertCartNotContainsProduct($crawler, $product['name']);
    }

    /**
     * @group Functional
     */
    public function testUpdateProductQuantity(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser());

        $product = $this->addRandomProductToCart($client);

        // Go to the cart page
        $crawler = $client->request('GET', '/cart');

        // Update the quantity
        $cartForm = $crawler->filter('form')->form([
            'show_cart[items][0][quantity]' => 4,
        ]);

        $client->submit($cartForm);
        $crawler = $client->followRedirect();

        $this->assertCartTotalEquals($crawler, $product['price'] * 4);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 4);
    }
}

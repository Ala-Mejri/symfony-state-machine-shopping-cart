<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\UI\CheckoutProcess\Action;

use App\Core\Presentation\UI\CheckoutProcess\Action\ShowCart\ShowCartAction;
use App\Core\Presentation\UI\CheckoutProcess\Action\ShowDeliveryAddress\ShowDeliveryAddressAction;
use App\Core\Presentation\UI\CheckoutProcess\Action\ShowOrderConfirmation\ShowOrderConfirmationAction;
use App\Core\Presentation\UI\CheckoutProcess\Action\ShowSummary\ShowSummaryAction;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\CartAssertionsTrait;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\ProductTrait;
use App\Tests\Functional\Presentation\UI\CheckoutProcess\Trait\UserTrait;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers ShowCartAction
 * @covers ShowDeliveryAddressAction
 * @covers ShowOrderConfirmationAction
 * @covers ShowSummaryAction
 */
class FullCheckoutProcessTest extends WebTestCase
{
    use ProductTrait;
    use CartAssertionsTrait;
    use UserTrait;

    const PRODUCT_ITEM_CSS_SELECTOR = '[itemtype="https://schema.org/Product"]';

    /**
     * @group Functional
     */
    public function testDeliveryAddress(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser());

        // Step 1: Test adding products to the cart
        $product = $this->addRandomProductToCart($client);
        $crawler = $client->request('GET', '/cart');
        $link = $crawler->filter('[data-id="checkout-address"]')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertCartItemsCountEquals($crawler, 1);
        $this->assertCartContainsProductWithQuantity($crawler, $product['name'], 1);
        $this->assertCartTotalEquals($crawler, $product['price']);

        // Step 2: Test submitting delivery address
        $crawler = $client->request('GET', '/checkout/address');
        $form = $crawler->filter('form[name="order_delivery_address"]')->form();
        $form->setValues([
            'order_delivery_address[name]' => 'Test user',
            'order_delivery_address[city]' => 1,
            'order_delivery_address[street]' => 'Random street',
            'order_delivery_address[postal_code]' => 14145424,
            'order_delivery_address[telephone_number]' => 123456789,
            'order_delivery_address[email]' => 'user@mail.com',

        ]);
        $client->submit($form);

        // Step 3: Test redirection to summary page
        $this->assertResponseRedirects("/checkout/summary");
        $crawler = $client->followRedirect();

        // Step 4: Test redirection to order page
        $link = $crawler->filter('[data-id="place-order"]')->link();
        $client->click($link);
        $this->assertEquals('/checkout/confirmation', $client->getRequest()->getRequestUri());

        // Step 5: Check if the order was placed successfully
        $crawler = $client->followRedirect();
        $orderId = $client->getRequest()->attributes->get('id');
        $actualCOrderReference = "Order #$orderId";
        $expectedOrderReference = $crawler
            ->filter('[data-id="order-reference"]')
            ->innerText();

        $this->assertResponseIsSuccessful();

        Assert::assertEquals($expectedOrderReference, $actualCOrderReference);
    }
}
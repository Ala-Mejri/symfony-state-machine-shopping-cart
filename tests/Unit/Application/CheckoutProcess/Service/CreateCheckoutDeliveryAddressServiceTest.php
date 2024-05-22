<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CheckoutProcess\Service;

use App\Core\Application\CheckoutProcess\Service\CreateCheckoutDeliveryAddressService;
use App\Core\Application\Order\Command\CreateOrderDeliveryAddress\CreateOrderDeliveryAddressCommand;
use App\Core\Application\User\Command\CreateUserDeliveryAddress\CreateUserDeliveryAddressCommand;
use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\Order\Enum\OrderStatusType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Tests\Unit\Application\CheckoutProcess\Trait\EntityReflection;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers CreateCheckoutDeliveryAddressService
 */
class CreateCheckoutDeliveryAddressServiceTest extends KernelTestCase
{
    use ProphecyTrait;
    use EntityReflection;

    private ObjectProphecy $commandBus;
    private CreateCheckoutDeliveryAddressService $createCheckoutDeliveryAddressService;

    protected function setUp(): void
    {
        $this->commandBus = $this->prophesize(CommandBusInterface::class);

        $this->createCheckoutDeliveryAddressService = new CreateCheckoutDeliveryAddressService($this->commandBus->reveal());

        parent::setUp();
    }

    /**
     * @group Unit
     * @dataProvider provideDeliveryAddressesWithoutIdData
     */
    public function testCreateDeliveryAddressesShouldDispatchCommandsWhenAddressIsWithoutId(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        // Arrange
        $order = $this->createOrder();

        $this->commandBus
            ->dispatch(new CreateOrderDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
                $order,
            ))
            ->shouldBeCalledOnce();

        $this->commandBus
            ->dispatch(new CreateUserDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
            ))
            ->shouldBeCalledOnce();

        // Act
        $this->createCheckoutDeliveryAddressService->createDeliveryAddresses($order, $orderDeliveryAddress);
    }

    /**
     * @group Unit
     * @dataProvider provideDeliveryAddressesWithIdData
     */
    public function testCreateDeliveryAddressesShouldNotDispatchCommandsWhenAddressHasId(OrderDeliveryAddress $orderDeliveryAddress): void
    {
        // Arrange
        $order = $this->createOrder();

        $this->commandBus
            ->dispatch(new CreateOrderDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
                $order,
            ))
            ->shouldNotBeCalled();

        $this->commandBus
            ->dispatch(new CreateUserDeliveryAddressCommand(
                $orderDeliveryAddress->getName(),
                $orderDeliveryAddress->getEmail(),
                $orderDeliveryAddress->getStreet(),
                $orderDeliveryAddress->getPostalCode(),
                $orderDeliveryAddress->getTelephoneNumber(),
                $orderDeliveryAddress->getTaxNumber(),
                $orderDeliveryAddress->getCity(),
            ))
            ->shouldNotBeCalled();

        // Act
        $this->createCheckoutDeliveryAddressService->createDeliveryAddresses($order, $orderDeliveryAddress);
    }

    public function provideDeliveryAddressesWithoutIdData(): array
    {
        return [
            'withTaxNumber' => [
                (new OrderDeliveryAddress())
                    ->setName('test user')
                    ->setEmail('test@email.com')
                    ->setStreet('Street')
                    ->setPostalCode(12345)
                    ->setTelephoneNumber('491236789')
                    ->setTaxNumber('A12345678910')
                    ->setCity(new City()),
            ],
            'withoutTaxNumber' => [
                (new OrderDeliveryAddress())
                    ->setName('test user')
                    ->setEmail('test@email.com')
                    ->setStreet('Street')
                    ->setPostalCode(12345)
                    ->setTelephoneNumber('491236789')
                    ->setCity(new City()),
            ],
        ];
    }

    public function provideDeliveryAddressesWithIdData(): array
    {
        return [
            'withTaxNumber' => [
                $this->setEntityId(
                    (new OrderDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setTaxNumber('A12345678910')
                        ->setCity(new City()),
                    1,
                )
            ],
            'withoutTaxNumber' => [
                $this->setEntityId(
                    (new OrderDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setCity(new City()),
                    2,
                )
            ],
        ];
    }

    private function createOrder(): Order
    {
        return (new Order())->setStatus(OrderStatusType::STATUS_SHOPPING_CART->value);
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CheckoutProcess\Service;

use App\Core\Application\CheckoutProcess\Service\GetCheckoutDeliveryAddressService;
use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Order\Entity\Order;
use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Domain\Order\Factory\OrderDeliveryAddressFactory;
use App\Core\Domain\User\Entity\User;
use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Domain\User\Enum\UserRoleType;
use App\Shared\Application\Service\CurrentUserService;
use App\Tests\Unit\Application\CheckoutProcess\Trait\EntityReflection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @covers GetCheckoutDeliveryAddressServiceTest
 */
class GetCheckoutDeliveryAddressServiceTest extends TestCase
{
    use ProphecyTrait;
    use EntityReflection;

    private ObjectProphecy $currentUserService;
    private ObjectProphecy $orderDeliveryAddressFactory;
    private GetCheckoutDeliveryAddressService $getCheckoutDeliveryAddressService;

    protected function setUp(): void
    {
        $this->currentUserService = $this->prophesize(CurrentUserService::class);
        $this->orderDeliveryAddressFactory = $this->prophesize(OrderDeliveryAddressFactory::class);

        $this->getCheckoutDeliveryAddressService = new GetCheckoutDeliveryAddressService(
            $this->currentUserService->reveal(),
            $this->orderDeliveryAddressFactory->reveal(),
        );

        parent::setUp();
    }

    /**
     * @group Unit
     * @dataProvider provideOrderHasDeliveryAddressData
     */
    public function testGetShouldReturnOrderDeliveryAddressWhenOrderHasDeliveryAddress(Order $order): void
    {
        // Arrange
        $expectedResult = $order->getDeliveryAddress();

        // Act
        $actualResult = $this->getCheckoutDeliveryAddressService->get($order);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @group Unit
     * @dataProvider provideUserHasPrimaryDeliveryAddressData
     */
    public function testGetShouldReturnOrderDeliveryAddressWhenUserHasPrimaryDeliveryAddress(
        Order                $order,
        User                 $user,
        OrderDeliveryAddress $expectedResult,
    ): void
    {
        // Arrange
        $this->currentUserService->getUser()
            ->shouldBeCalledOnce()
            ->willReturn($user);

        $this->orderDeliveryAddressFactory
            ->createFromUserDeliveryAddress($user->getPrimaryDeliveryAddress())
            ->shouldBeCalledOnce()
            ->willReturn($expectedResult);

        // Act
        $actualResult = $this->getCheckoutDeliveryAddressService->get($order);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @group Unit
     * @dataProvider provideOrderDeliveryAddressFromUserData
     */
    public function testGetShouldReturnOrderDeliveryAddressFromUserData(
        Order                $order,
        User                 $user,
        OrderDeliveryAddress $expectedResult,
    ): void
    {
        // Arrange
        $this->currentUserService->getUser()
            ->shouldBeCalledOnce()
            ->willReturn($user);

        $this->orderDeliveryAddressFactory
            ->createFromUser($user)
            ->shouldBeCalledOnce()
            ->willReturn($expectedResult);

        // Act
        $actualResult = $this->getCheckoutDeliveryAddressService->get($order);

        // Assert
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideOrderHasDeliveryAddressData(): array
    {
        return [
            [
                'withTaxNumber' => (new Order())->setDeliveryAddress(
                    (new OrderDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setTaxNumber('A12345678910')
                        ->setCity(new City()),
                ),
            ],
            [
                'withoutTaxNumber' => (new Order())->setDeliveryAddress(
                    (new OrderDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setCity(new City()),
                ),
            ],
        ];
    }

    public function provideUserHasPrimaryDeliveryAddressData(): array
    {
        return [
            'withTaxNumber' => [
                new Order(),
                (new User())->addDeliveryAddress(
                    (new UserDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setTaxNumber('A12345678910')
                        ->setCity(new City()),
                ),
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
                new Order(),
                (new User())->addDeliveryAddress(
                    (new UserDeliveryAddress())
                        ->setName('test user')
                        ->setEmail('test@email.com')
                        ->setStreet('Street')
                        ->setPostalCode(12345)
                        ->setTelephoneNumber('491236789')
                        ->setCity(new City()),
                ),
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

    public function provideOrderDeliveryAddressFromUserData(): array
    {
        return [
            'admin' => [
                new Order(),
                (new User())
                    ->setName('test user')
                    ->setEmail('test@email.com')
                    ->addRole(UserRoleType::ROLE_ADMIN),
                (new OrderDeliveryAddress())
                    ->setName('test user')
                    ->setEmail('test@email.com'),
            ],
            'user' => [
                new Order(),
                (new User())
                    ->setName('test user')
                    ->setEmail('test@email.com')
                    ->addRole(UserRoleType::ROLE_USER),
                (new OrderDeliveryAddress())
                    ->setName('test user')
                    ->setEmail('test@email.com'),
            ],
        ];
    }
}
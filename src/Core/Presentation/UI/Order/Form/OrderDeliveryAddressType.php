<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\Order\Form;

use App\Core\Domain\Order\Entity\OrderDeliveryAddress;
use App\Core\Presentation\UI\DeliveryAddress\Form\AbstractDeliveryAddressType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderDeliveryAddressType extends AbstractDeliveryAddressType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDeliveryAddress::class,
        ]);
    }
}

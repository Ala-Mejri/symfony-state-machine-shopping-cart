<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Form;

use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Presentation\UI\DeliveryAddress\Form\AbstractDeliveryAddressType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserDeliveryAddressType extends AbstractDeliveryAddressType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDeliveryAddress::class,
        ]);
    }
}

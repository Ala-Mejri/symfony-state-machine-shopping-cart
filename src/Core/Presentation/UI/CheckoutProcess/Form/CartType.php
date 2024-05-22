<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\CheckoutProcess\Form;

use App\Core\Domain\Order\Entity\Order;
use App\Core\Presentation\UI\CheckoutProcess\Form\EventListener\ClearCartListener;
use App\Core\Presentation\UI\CheckoutProcess\Form\EventListener\RemoveCartItemListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('items', CollectionType::class, [
                'entry_type' => CartItemType::class
            ]);

        $builder->addEventSubscriber(new RemoveCartItemListener());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

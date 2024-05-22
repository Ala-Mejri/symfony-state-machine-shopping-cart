<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\DeliveryAddress\Form;

use App\Core\Application\Country\Query\GetFirstCountry\GetFirstCountryQuery;
use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Country\Entity\Country;
use App\Core\Domain\DeliveryAddress\Entity\DeliveryAddress;
use App\Core\Presentation\UI\DeliveryAddress\Form\EventListener\DeliveryAddressTypeListener;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

abstract class AbstractDeliveryAddressType extends AbstractType
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'mapped' => false,
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choices' => [],
            ])
            ->add('tax_number', TextType::class)
            ->add('street', TextType::class)
            ->add('postal_code', IntegerType::class)
            ->add('telephone_number', TextType::class)
            ->add('email', TextType::class)
            ->add('submit', SubmitType::class);

        $this->handlePreSetData($builder);

        $builder->get('country')->addEventSubscriber(new DeliveryAddressTypeListener($this->queryBus));
    }

    private function handlePreSetData(FormBuilderInterface $builder): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $form = $event->getForm();
            /* @var  DeliveryAddress $deliveryAddress */
            $deliveryAddress = $event->getData();
            $country = $deliveryAddress?->getCity()?->getCountry() ?? $this->queryBus->ask(new GetFirstCountryQuery());

            if (!$country instanceof Country) {
                return;
            }

            if (!$country->isIsMemberOfEu()) {
                $form->remove('tax_number');
            }

            $form->add('city', EntityType::class, [
                'class' => City::class,
                'choices' => $country->getCities(),
            ]);
        });
    }
}

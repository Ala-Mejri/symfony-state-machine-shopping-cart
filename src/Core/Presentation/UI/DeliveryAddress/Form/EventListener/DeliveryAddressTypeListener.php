<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\DeliveryAddress\Form\EventListener;

use App\Core\Application\City\Query\FindFirstCountryCities\FindFirstCountryCitiesQuery;
use App\Core\Domain\City\Entity\City;
use App\Core\Domain\Country\Entity\Country;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final readonly class DeliveryAddressTypeListener implements EventSubscriberInterface
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit',
        ];
    }

    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $country = $form->getData();

        $cities = $country instanceof Country
            ? $country->getCities()
            : $this->queryBus->ask(new FindFirstCountryCitiesQuery());

        $form->getParent()->add('city', EntityType::class, [
            'class' => City::class,
            'choices' => $cities,
        ]);

        if ($country instanceof Country && $country?->isIsMemberOfEu()) {
            $form->getParent()->add('tax_number', TextType::class);
        } else {
            $form->getParent()->remove('tax_number');
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\CreateUserDeliveryAddress;

use App\Core\Application\User\Command\CreateUserDeliveryAddress\CreateUserDeliveryAddressCommand;
use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Presentation\UI\User\Form\UserDeliveryAddressType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Presentation\Service\ActionFlashService;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-delivery-address/create', name: 'app.address.create')]
final class CreateUserDeliveryAddressAction extends AbstractController
{
    public function __construct(
        private readonly ActionFormHandler                  $actionFormHandler,
        private readonly CreateUserDeliveryAddressResponder $responder,
        private readonly CommandBusInterface                $commandBus,
        private readonly ActionFlashService                 $actionFlashService,
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->actionFormHandler->handleFormRequest(UserDeliveryAddressType::class, $request);

        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($form);
        }

        $this->saveUserDeliveryAddress($form);
        $this->actionFlashService->addEntityCreatedFlash(UserDeliveryAddress::class);

        return $this->responder->redirect();
    }

    private function saveUserDeliveryAddress(FormInterface $form): void
    {
        /* @var UserDeliveryAddress $userDeliveryAddress */
        $userDeliveryAddress = $form->getData();

        $this->commandBus->dispatch(
            new CreateUserDeliveryAddressCommand(
                $userDeliveryAddress->getName(),
                $userDeliveryAddress->getEmail(),
                $userDeliveryAddress->getStreet(),
                $userDeliveryAddress->getPostalCode(),
                $userDeliveryAddress->getTelephoneNumber(),
                $userDeliveryAddress->getTaxNumber(),
                $userDeliveryAddress->getCity(),
            ),
        );
    }
}
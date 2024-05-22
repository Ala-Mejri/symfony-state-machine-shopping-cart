<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\UpdateUserDeliveryAddress;

use App\Core\Application\User\Command\UpdateUserDeliveryAddress\UpdateUserDeliveryAddressCommand;
use App\Core\Application\User\Query\FindUserDeliveryAddress\FindUserDeliveryAddressQuery;
use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Domain\User\Exception\UserDeliveryAddressNotFoundException;
use App\Core\Presentation\UI\User\Form\UserDeliveryAddressType;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Application\Bus\Query\QueryBusInterface;
use App\Shared\Domain\Primitive\Exception\EntityAccessForbiddenException;
use App\Shared\Presentation\Service\ActionFlashService;
use App\Shared\Presentation\Service\ActionFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-delivery-address/update/{id}', name: 'app.address.update')]
final class UpdateUserDeliveryAddressAction extends AbstractController
{
    public function __construct(
        private readonly UpdateUserDeliveryAddressResponder $responder,
        private readonly ActionFormHandler                  $actionFormHandler,
        private readonly QueryBusInterface                  $queryBus,
        private readonly CommandBusInterface                $commandBus,
        private readonly ActionFlashService                 $actionFlashService,
    )
    {
    }

    public function __invoke(int $id, Request $request): Response
    {
        try {
            $userDeliveryAddress = $this->queryBus->ask(new FindUserDeliveryAddressQuery($id));
        } catch (UserDeliveryAddressNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        } catch (EntityAccessForbiddenException $exception) {
            throw $this->responder->createAccessDeniedException($exception->getMessage());
        }

        $form = $this->actionFormHandler->handleFormRequest(UserDeliveryAddressType::class, $request, $userDeliveryAddress);

        if (!$this->actionFormHandler->isFormSubmittedAndValid($form)) {
            return $this->responder->respond($userDeliveryAddress, $form);
        }

        $userDeliveryAddress = $this->updateDeliveryAddress($form);
        $this->actionFlashService->addEntityUpdatedFlash(UserDeliveryAddress::class);

        return $this->responder->redirect($userDeliveryAddress);
    }

    private function updateDeliveryAddress(FormInterface $form): UserDeliveryAddress
    {
        /* @var UserDeliveryAddress $userDeliveryAddress */
        $userDeliveryAddress = $form->getData();

        $this->commandBus->dispatch(
            new UpdateUserDeliveryAddressCommand(
                $userDeliveryAddress->getId(),
                $userDeliveryAddress->getName(),
                $userDeliveryAddress->getEmail(),
                $userDeliveryAddress->getStreet(),
                $userDeliveryAddress->getPostalCode(),
                $userDeliveryAddress->getTelephoneNumber(),
                $userDeliveryAddress->getTaxNumber(),
                $userDeliveryAddress->getCity(),
            ),
        );

        return $userDeliveryAddress;
    }
}
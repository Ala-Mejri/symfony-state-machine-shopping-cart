<?php

declare(strict_types=1);

namespace App\Core\Presentation\UI\User\Action\DeleteUserDeliveryAddress;

use App\Core\Application\User\Command\DeleteUserDeliveryAddress\DeleteUserDeliveryAddressCommand;
use App\Core\Domain\User\Entity\UserDeliveryAddress;
use App\Core\Domain\User\Exception\UserDeliveryAddressNotFoundException;
use App\Shared\Application\Bus\Command\CommandBusInterface;
use App\Shared\Domain\Primitive\Exception\EntityAccessForbiddenException;
use App\Shared\Presentation\Service\ActionFlashService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-delivery-address/delete/{id}', name: 'app.address.delete', methods: ['GET', 'DELETE'])]
final class DeleteUserDeliveryAddressAction extends AbstractController
{
    public function __construct(
        private readonly DeleteUserDeliveryAddressResponder $responder,
        private readonly CommandBusInterface                $commandBus,
        private readonly ActionFlashService                 $actionFlashService,
    )
    {
    }

    public function __invoke(int $id): Response
    {
        try {
            $this->commandBus->dispatch(new DeleteUserDeliveryAddressCommand($id));
        } catch (UserDeliveryAddressNotFoundException $exception) {
            throw $this->responder->createNotFoundException($exception->getMessage());
        } catch (EntityAccessForbiddenException $exception) {
            throw $this->responder->createAccessDeniedException($exception->getMessage());
        }

        $this->actionFlashService->addEntityDeletedFlash(UserDeliveryAddress::class);

        return $this->responder->redirect();
    }
}